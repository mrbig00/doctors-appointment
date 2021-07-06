<?php
/**
 * @package    doctors-appointment
 * @author     Zoltan Szanto <mrbig00@gmail.com>
 * @copyright  2021 Zoltán Szántó
 */

namespace app\models\form;

use app\repositories\AppointmentRepository;
use yii\base\Model;

/**
 * Class AppointmentForm
 *
 * @package app\models\form
 */
class AppointmentForm extends Model
{
    public $patientName;
    public $dateStart;
    public $dateEnd;
    public $timeStart;
    public $timeEnd;
    public $repeat;

    public function rules()
    {
        return [
            [['patientName', 'dateStart', 'dateEnd', 'timeStart', 'timeEnd', 'repeat'], 'safe'],
            [['patientName', 'dateStart', 'timeStart', 'timeEnd', 'repeat'], 'required'],
            [['patientName'], 'string', 'min' => 5, 'max' => '100'],
            ['repeat', 'in', 'strict' => true, 'range' => ['none', 'weekly', 'biWeekly']],
            [['timeStart', 'timeEnd'], 'date', 'format' => 'php:H:i'],
            [['dateStart', 'dateEnd'], 'date', 'format' => 'php:Y-m-d'],
            ['timeStart', 'validateTime'],
            ['timeStart', 'compare', 'compareAttribute' => 'timeEnd', 'operator' => '<', 'type' => 'date'],
            [
                'dateStart',
                'compare',
                'compareAttribute' => 'dateEnd',
                'operator' => '<',
                'type' => 'date',
                'when' => function ($model) {
                    /**
                     * @var $model self
                     */
                    return $model->isRepeating();
                },
            ],
            [
                ['dateEnd'],
                'required',
                'when' => function ($model) {
                    /**
                     * @var $model self
                     */
                    return $model->isRepeating();
                },
            ],
        ];
    }

    public function isRepeating()
    {
        return in_array($this->repeat, ['weekly', 'biWeekly']);
    }

    public function getRepeatInterval()
    {
        if ($this->repeat === 'weekly') {
            return 7 * 24 * 60 * 60;
        }

        if ($this->repeat === 'biWeekly') {
            return 7 * 24 * 60 * 60 * 2;
        }

        return null;
    }

    public function validateTime($attribute, $params, $validator)
    {
        $date = new \DateTime($this->dateStart, new \DateTimeZone('UTC'));
        $appointments = AppointmentRepository::findForDay($date);
        if (count($appointments) > 0) {
            foreach ($appointments as $appointment) {
                if (!$this->checkOverlap($this->timeStart, $this->timeEnd, $appointment->start, $appointment->end)) {
                    $this->addError($attribute, 'There are already appointments at that time');
                }
            }
        }
    }

    function checkOverlap($from, $to, $fromCompare, $toCompare)
    {
        return ($from <= $toCompare && $fromCompare <= $to);
    }
}
