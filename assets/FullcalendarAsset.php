<?php
/**
 * @package    doctors-appointment
 * @author     Zoltan Szanto <mrbig00@gmail.com>
 * @copyright  2021 Zoltán Szántó
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class FullcalendarAsset
 *
 * @package app\assets
 */
class FullcalendarAsset extends AssetBundle
{
    public $js = [
        'https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.min.js'
    ];

    public $css = [
        'https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.min.css'
    ];
}
