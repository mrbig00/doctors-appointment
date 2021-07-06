<?php
/**
 * @package    doctors-appointment
 * @author     Zoltan Szanto <mrbig00@gmail.com>
 * @copyright  2021 Zoltán Szántó
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class AppointmentAsset
 *
 * @package app\assets
 */
class AppointmentAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $css      = [
        'css/appointment.css',
    ];
    public $js       = [
        'js/appointment.js',
    ];
    public $depends  = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        FullcalendarAsset::class,
    ];
}
