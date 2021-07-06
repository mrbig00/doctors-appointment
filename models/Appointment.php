<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "appointments".
 *
 * @property int $id
 * @property string $title
 * @property string|null $start_time
 * @property string|null $end_time
 *
 * @property AppointmentMeta[] $appointmentMetas
 */
class Appointment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appointments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['start_time', 'end_time'], 'safe'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
        ];
    }

    /**
     * Gets query for [[AppointmentMetas]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\AppointmentMetaQuery
     */
    public function getAppointmentMetas()
    {
        return $this->hasMany(AppointmentMeta::class, ['appointment_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\AppointmentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\AppointmentsQuery(get_called_class());
    }
}
