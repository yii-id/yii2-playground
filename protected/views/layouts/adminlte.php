<?php

use yii\helpers\Html;
use app\assets\AdminLteAsset;
use app\classes\widgets\SideNav;
use app\classes\widgets\Route;
use app\classes\widgets\SelectThemeCode;

/* @var $this \yii\web\View */
/* @var $content string */

AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style type="text/css">
            .hashlink {
                display: none;
            }
            h1:hover .hashlink, h2:hover .hashlink, h3:hover .hashlink,
            h4:hover .hashlink, h5:hover .hashlink {
                display: inline;
                color: gray;
                font-size: 0.8em;
            }
            .tool-link{
                float: right;
                color: gray;
                font-size: 0.8em;
            }
        </style>
    </head>
    <?php $this->beginBody() ?>
    <body class="skin-blue sidebar-mini">
        <div class="wrapper">
            <?= $this->render('header'); ?>
            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="input-group">
                        <?=
                        SelectThemeCode::widget([
                            'options' => ['class' => 'form-control']
                        ]);
                        ?>
                    </div>
                    <?php
                    echo SideNav::widget([
                        'options' => [
                            'class' => 'sidebar-menu',
                        ],
                        'items' => Route::getMenuItems(),
                    ]);
                    ?>
                </section>
            </aside>
            <div class="content-wrapper">
<?= $content; ?>
            </div>

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    Version 2.0
                </div>
                <strong>Copyright &copy; 2015 <a href="#">Deesoft</a>.</strong> All rights reserved.
            </footer>
        </div>
<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
