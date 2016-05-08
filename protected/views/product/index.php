<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Product */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contoh Export';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        $url = array_filter(Yii::$app->getRequest()->get());
        $url[0] = 'export-csv';
        unset($url['page']);
        echo Html::a('Export To csv', $url, [
            'class' => 'btn btn-success', 'target' => '_blank'])
        ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'code',
            'name',
            [
                'label' => 'Category',
                'attribute' => 'category_id',
                'value' => 'category.name',
                'filter' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
            ],
            'status',
        ],
    ]);
    ?>

</div>
