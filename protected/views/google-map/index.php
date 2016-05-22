<?php

use yii\web\View;
use yii\helpers\Url;

//use yii\helpers\Html;

/* @var $this View */
$url = 'https://maps.googleapis.com/maps/api/js?key=' . Yii::$app->params['google.api.key'];
$this->registerJsFile($url, ['async' => false, 'defer' => true]);

$this->registerJs('var urlImsakiyah = ' . json_encode(Url::to(['imsakiyah'])) . ';');
$this->registerJs($this->render('script.js'));
?>
<div class="col-md-8">
    <div id="map" style="height: 400px;"></div>
</div>
<div class="col-md-4">
    <div id="location-name"></div>
    <div id="location-zone"></div>
    <div id="location-cord"></div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="50%">&nbsp;</th>
                <th>Jam</th>
            </tr>
        </thead>
        <tbody id="body-tbl">
        </tbody>
    </table>
</div>
