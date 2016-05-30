<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PageStatistic */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Page Statistics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-statistic-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'page_title',
                'value' => function($model) {
                    $title = $model->page_title ? : $model->url;
                    return Html::a($title, $model->url);
                },
                'footer' => 'Total Hit',
                'format' => 'raw',
            ],
            [
                'attribute' => 'count',
                'label' => 'Hit',
                'footer' => $total['count'],
                'contentOptions'=>['align'=>'right'],
                'footerOptions'=>['align'=>'right'],
            ],
            [
                'attribute' => 'unique_count',
                'label' => 'Unique Hit',
                'footer' => $total['unique_count'],
                'contentOptions'=>['align'=>'right'],
                'footerOptions'=>['align'=>'right'],
            ],
            [
                'attribute' => 'time',
                'value' => function($model) {
                    return date('d M Y', $model->time);
                },
                'label' => 'Last View',
                'filter' => false
            ],
        ],
    ]);
    ?>

</div>
