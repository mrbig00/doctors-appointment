<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "appointment_meta".
 *
 * @property int         $id
 * @property int|null    $appointment_id
 * @property int|null    $repeat_start
 * @property int|null    $repeat_end
 * @property int|null    $repeat_interval
 * @property string|null $repeat_week
 *
 * @property Appointment $appointment
 */
class AppointmentMeta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appointments_meta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['appointment_id', 'repeat_start', 'repeat_interval'], 'integer'],
            [['repeat_end'], 'safe'],
            [['repeat_week',], 'string', 'max' => 2],
            [
                ['appointment_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Appointment::class,
                'targetAttribute' => ['appointment_id' => 'id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appointment_id' => 'Appointment ID',
            'repeat_start' => 'Repeat Start',
            'repeat_end' => 'Repeat End',
            'repeat_interval' => 'Repeat Interval',
            'repeat_week' => 'Repeat Week',
        ];
    }

    /**
     * Gets query for [[Appointment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppointment()
    {
        return $this->hasOne(Appointment::class, ['id' => 'appointment_id']);
    }
}
