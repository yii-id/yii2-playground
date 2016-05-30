<?php

namespace app\controllers;

use Yii;
use app\models\search\PageStatistic as PageStatisticSearch;
use yii\web\Controller;

/**
 * PageStatisticController implements the CRUD actions for PageStatistic model.
 */
class PageStatisticController extends Controller
{
    public $layout = 'playground';

    /**
     * Lists all PageStatistic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageStatisticSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $total = (new \yii\db\Query())
            ->select(['count' => 'sum([[count]])', 'unique_count' => 'sum([[unique_count]])'])
            ->from('{{%page_statistic}}')
            ->one();
        $dataProvider->pagination = false;
        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'total' => $total,
        ]);
    }
}
