<?php

use yii\db\Migration;

/**
 * Class m210705_144201_appointments
 */
class m210705_144201_appointments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'appointments',
            [
                'id' => $this->primaryKey(),
                'title' => $this->string(100)->notNull(),
                'start_time' => $this->time()->null(),
                'end_time' => $this->time()->null(),
            ]
        );

        $this->createTable(
            'appointments_meta',
            [
                'id' => $this->primaryKey(),
                'appointment_id' => $this->integer()->notNull(),
                'repeat_start' => $this->integer(),
                'repeat_end' => $this->date(),
                'repeat_interval' => $this->integer(),
                'repeat_week' => $this->string(10),
            ]
        );

        $this->addForeignKey(
            'fk_appointment_meta_appointments_id',
            'appointments_meta',
            'appointment_id',
            'appointments',
            'id',
            'cascade',
            'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("appointments");
    }
}
