<?php

/* @var $this yii\web\View */

$this->title = 'Appointments';
\app\assets\AppointmentAsset::register($this);
?>
<div class="site-index">

    <div id="calendar">
    </div>
    <?= $this->render('_modal'); ?>
</div>
