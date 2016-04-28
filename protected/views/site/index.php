<?php
use yii\web\View;
use yii\helpers\Markdown;
use app\assets\SourceAsset;

/* @var $this View */
SourceAsset::register($this);
$this->title = 'Yii2 Playground';
$contribusi = file_get_contents(Yii::getAlias('@root/docs/cara-kontribusi.md'));
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Selamat Datang!</h1>
        <p class="lead">Aplikasi Yii2 Playground</p>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
                <h2>Playground</h2>
                <?= Markdown::process($contribusi, 'mdm') ?>
                <p><a class="btn btn-default" href="https://github.com/yii-id/yii2-playground">Fork Github &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
