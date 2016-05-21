<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Imsakiyah;

/**
 * Description of GoogleMap
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class GoogleMapController extends Controller
{
    public $layout = 'playground';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionImsakiyah($lat, $lng, $rawOffset = '')
    {
        \Yii::$app->getResponse()->format = 'json';
        $model = new Imsakiyah([
            'bujur' => $lng,
            'lintang' => $lat,
            'rawOffset' => $rawOffset,
        ]);

        if ($model->validate()) {
            return array_map(function($v) {
                return date('H:i:s', $v);
            }, $model->getImsakiyah());
        }
        return [];
    }
}
