<?php
/**
 * @package    doctors-appointment
 * @author     Zoltan Szanto <mrbig00@gmail.com>
 * @copyright  2021 Zoltán Szántó
 */

namespace app\repositories;

use app\models\Appointment;
use app\models\CalendarEvent;
use DateInterval;
use DatePeriod;
use DateTime;

/**
 * Class AppointmentRepository
 *
 * @package app\repositories
 */
class AppointmentRepository
{
    public function findByInterval(DateTime $dateStart, DateTime $dateEnd)
    {
        $events = [];

        $period = new DatePeriod(
            $dateStart,
            DateInterval::createFromDateString('1 day'),
            $dateEnd
        );

        foreach ($period as $period) {
            $events = array_merge($events, static::findForDay($period));
        }

        return $events;
    }

    public static function findForDay(DateTime $date)
    {
        $date->setTime(0, 0, 0);
        $appointments = Appointment::find()
            ->joinWith('appointmentMetas', true, 'RIGHT JOIN')
            ->andWhere("((:currentTime - repeat_start) % repeat_interval = 0 or repeat_start = :currentTime)",
                [':currentTime' => $date->getTimestamp()])
            ->andWhere([
                'or',
                ['>', 'repeat_end', $date->format('Y-m-d')],
                ['repeat_end' => null],
            ])
            ->andWhere(
                ['<=', "DATE_FORMAT(FROM_UNIXTIME(`repeat_start`), '%Y-%m-%d')", $date->format('Y-m-d')]
            )
            ->all();
        $return = [];
        foreach ($appointments as $event) {
            $return[] = new CalendarEvent(
                [
                    'title' => $event->title,
                    'start' => "{$date->format("Y-m-d")} {$event->start_time}",
                    'end' => "{$date->format("Y-m-d")} {$event->end_time}",
                ]
            );
        }

        return $return;
    }
}
