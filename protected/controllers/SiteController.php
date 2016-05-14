<?php

namespace app\controllers;

use Yii;
use app\models\form\Contact;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return[
            [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'change-style' => ['POST']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'mdm\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                // 'level' => 3
            ],
            'page' => [
                'class' => 'yii\web\ViewAction',
                'viewPrefix' => '@app/views/pages',
                'layout' => 'playground',
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionContact()
    {
        $model = new Contact();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                    'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionChangeTheme($for)
    {
        Yii::$app->getResponse()->format = 'json';
        $style = \Yii::$app->getRequest()->post('style', '');
        Yii::$app->profile->set($for, $style);
        return $style;
    }
}
