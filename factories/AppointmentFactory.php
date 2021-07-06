<?php
/**
 * @package    doctors-appointment
 * @author     Zoltan Szanto <mrbig00@gmail.com>
 * @copyright  2021 Zoltán Szántó
 */


namespace app\factories;


use app\models\Appointment;
use app\models\AppointmentMeta;
use App\Models\Event;
use app\models\form\AppointmentForm;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Cassandra\Date;
use yii\base\BaseObject;
use yii\web\IdentityInterface;

class AppointmentFactory
{
    /**
     * @var string
     */
    private $date;
    /**
     * @var string
     */
    private $startTime;
    /**
     * @var string
     */
    private $endTime;
    /**
     * @var null
     */
    private $repeatInterval;

    /**
     * @var string
     */
    private $title;

    /**
     * @var Appointment
     */
    private $appointment;

    /**
     * @var AppointmentMeta
     */
    private $appointmentMeta;
    private $endDate;

    /**
     * AppointmentFactory constructor.
     *
     * @param string $date
     * @param string $startTime
     * @param string $endTime
     * @param string $title
     * @param null   $repeatInterval
     */
    protected function __construct(
        string $date,
        string $startTime,
        ?string $endTime,
        string $title,
        $repeatInterval,
        $endDate = null
    ) {
        $this->date = new \DateTime($date);
        $this->date->setTimezone(new \DateTimeZone('UTC'));
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->repeatInterval = $repeatInterval;
        $this->title = $title;
        if (!empty($this->endDate)) {
            $this->endDate = new \DateTime($endDate);
        }
    }

    protected function create()
    {
        $this->initAppointment();
        $this->initAppointmentMeta();

        return $this->appointment;
    }

    protected function initAppointmentMeta(): void
    {
        $this->eventMeta = new AppointmentMeta();
        $this->eventMeta->appointment_id = \Yii::$app->db->lastInsertID;
        $this->eventMeta->repeat_start = $this->date->setTime(24, 0, 0)->getTimestamp();
        if (!empty($this->endDate)) {
            $this->eventMeta->repeat_end = $this->endDate->setTime(24, 59, 59)->format("Y-m-d");
        }
        $this->eventMeta->repeat_interval = $this->repeatInterval;
        if (!$this->eventMeta->save()) {
            throw new \UnexpectedValueException(implode(', ', $this->appointment->getFirstErrors()));
        }
    }

    protected function initAppointment(): void
    {
        $this->appointment = new Appointment();
        $this->appointment->start_time = $this->startTime;
        $this->appointment->end_time = $this->endTime;
        $this->appointment->title = $this->title;

        if (!$this->appointment->save()) {
            throw new \UnexpectedValueException(implode(', ', $this->appointment->getFirstErrors()));
        }
    }

    /**
     * @param string $date
     * @param string $startTime
     * @param string $endTime
     * @param string $title
     *
     * @return Appointment
     */
    public static function createAppointment(
        string $date,
        string $startTime,
        ?string $endTime,
        string $title,
        ?int $repeatInterval,
        $endDate = null
    ): Appointment {
        $factory = new self($date, $startTime, $endTime, $title, $repeatInterval, $endDate);

        return $factory->create();
    }

    public static function fromForm(AppointmentForm $form)
    {
        return static::createAppointment($form->dateStart, $form->timeStart, $form->timeEnd, $form->patientName, $form->getRepeatInterval());
    }
}
