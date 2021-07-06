<?php

use app\dictionaries\RepeatDictionary;
use app\factories\AppointmentFactory;
use app\models\Appointment;
use yii\db\Migration;

/**
 * Class m210705_153000_appointments_seed
 */
class m210705_153000_appointments_seed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $event = AppointmentFactory::createAppointment(
            "2021-06-08 00:00:00",
            "08:00",
            "10:00",
            "Wonder Woman",
            null
        );

        $event = AppointmentFactory::createAppointment(
            "2021-01-11 00:00:00",
            "10:00",
            "12:00",
            "Spider-man",
            604800 * 2
        );

        $event = AppointmentFactory::createAppointment(
            "2021-01-06 00:00:00",
            "12:00",
            "16:00",
            "Batman",
            604800 * 2

        );

        $event = AppointmentFactory::createAppointment(
            "2021-01-01 00:00:00",
            "10:00",
            "16:00",
            "Wolverine",
            604800

        );

        $event = AppointmentFactory::createAppointment(
            "2021-01-07 00:00:00",
            "16:00",
            "20:00",
            "Flash",
            604800,
            "2021-11-30"

        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210705_153000_appointments_seed cannot be reverted.\n";

        return false;
    }
}
