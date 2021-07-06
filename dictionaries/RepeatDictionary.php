<?php
/**
 * @package    doctors-appointment
 * @author     Zoltan Szanto <mrbig00@gmail.com>
 * @copyright  2021 Zoltán Szántó
 */

namespace app\dictionaries;

/**
 * Class RepeatDictionary
 *
 * @package app\dictionaries
 */
abstract class RepeatDictionary
{
    const REPEAT_NONE = null;
    const REPEAT_EVERY_WEEK = "everyWeek";
    const REPEAT_ODD_WEEK = "oddWeek";
    const REPEAT_EVEN_WEEK = "evenWeek";
}
