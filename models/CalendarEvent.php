<?php
/**
 * @package    doctors-appointment
 * @author     Zoltan Szanto <mrbig00@gmail.com>
 * @copyright  2021 Zoltán Szántó
 */

namespace app\models;

use yii\base\Model;

/**
 * Class CalendarEvent
 *
 * @package app\models
 */
class CalendarEvent extends Model
{
    public $title;
    public $start;
    public $end;
}
