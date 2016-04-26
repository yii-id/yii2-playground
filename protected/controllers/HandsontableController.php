<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * HandsontableController.
 */
class HandsontableController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionInput()
    {
        return $this->render('input');
    }
}
