<?php
/**
 * @package    doctors-appointment
 * @author     Zoltan Szanto <mrbig00@gmail.com>
 * @copyright  2021 Zoltán Szántó
 */

namespace app\controllers;

use app\factories\AppointmentFactory;
use app\models\form\AppointmentForm;
use app\repositories\AppointmentRepository;
use DateInterval;
use DatePeriod;
use DateTime;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotAcceptableHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class AppointmentsController
 *
 * @package app\controllers
 */
class AppointmentsController extends Controller
{
    public function actionIndex($start, $end)
    {
        $repository = new AppointmentRepository();
        $start = new DateTime($start);
        $start->setTimezone(new \DateTimeZone('UTC'));
        $end = new DateTime($end);
        $end->setTimezone(new \DateTimeZone('UTC'));

        return $repository->findByInterval($start, $end);
    }

    public function actionBackground($start, $end)
    {
        $period = new DatePeriod(
            new DateTime($start),
            DateInterval::createFromDateString('1 day'),
            new DateTime($end)
        );

        $events = [];
        foreach ($period as $dateTime) {
            $events[] = [
                'start' => (clone $dateTime)->setTime(8, 0)->format('Y-m-d H:i:s'),
                'end' => (clone $dateTime)->setTime(16, 0)->format('Y-m-d H:i:s'),
                'display' => 'background',
            ];
        }

        return $events;
    }

    public function actionCreate(Request $request, Response $response)
    {
        $form = new AppointmentForm();
        $form->load(json_decode($request->rawBody, true), '');
        if (!$form->validate()) {
            return [
                'error' => implode(',', $form->getFirstErrors()),
            ];
        }

        return [
            'error' => false,
            'form' => $form,
            'appointment' => AppointmentFactory::fromForm($form)
        ];
    }
}
