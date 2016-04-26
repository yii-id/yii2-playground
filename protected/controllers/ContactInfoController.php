<?php

namespace app\controllers;

use Yii;
use app\models\ContactInfo;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * Description of ContactInfoController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ContactInfoController extends Controller
{
    public $layout = 'main.twig';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $contacts = ContactInfo::find()->all();

        return $this->render('index.twig', ['contacts' => $contacts]);
    }

    public function actionCreate()
    {
        $model = new ContactInfo();

        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create.twig', ['model' => $model]);
    }

    public function actionView($id)
    {
        $model = ContactInfo::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view.twig', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = ContactInfo::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update.twig', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = ContactInfo::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        $model->delete();
        return $this->redirect(['index']);
    }
}
