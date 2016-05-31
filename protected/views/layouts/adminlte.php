<?php

use yii\helpers\Html;
use app\assets\AdminLteAsset;
use app\classes\widgets\SideNav;
use app\classes\widgets\Route;
use app\classes\widgets\SelectThemeCode;
use app\classes\widgets\Disqus;
use yii\helpers\Url;
use app\classes\widgets\PageStat;

/* @var $this \yii\web\View */
/* @var $content string */

AdminLteAsset::register($this);
$skins = ['black', 'blue', 'green', 'purple', 'red', 'yellow',
    'black-light', 'blue-light', 'green-light', 'purple-light', 'red-light', 'yellow-light',
];
$skin = Yii::$app->profile->skin ? : 'red';
$collapse = Yii::$app->profile->collapse;
$opts = json_encode([
    'changeSkinUrl' => Url::to(['/site/change-theme', 'for' => 'skin']),
    'changeCollapseUrl' => Url::to(['/site/change-theme', 'for' => 'collapse']),
    'skin' => 'skin-' . $skin,
    'collapse' => $collapse,
    ]);

$this->registerJs('var chatUrl = ' . json_encode(Url::to(['/chat/message', 'notifOnly' => 1])) . ';');
$this->registerJs($this->render('adminlte.js'));
$this->registerJs("skinAdmin({$opts});");
$collapse = $collapse == 'yes' ? 'sidebar-collapse' : '';

list(, $mainUrl) = $this->assetManager->publish('@app/assets/main');
$this->registerMetaTag(['property' => 'og:image', 'content' => $mainUrl . '/img/Yii2.png']);
$this->registerMetaTag(['property' => 'og:title', 'content' => $this->title]);
$this->registerLinkTag(['rel' => 'image_src', 'href' => $mainUrl . '/img/Yii2.png']);
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
            img.emoji{
                height: 1em;
            }
        </style>
    </head>
    <?php $this->beginBody() ?>
    <body class="skin-<?= $skin ?> sidebar-mini <?= $collapse; ?>">
        <div class="wrapper">
            <?= $this->render('header'); ?>
            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="sidebar-form">
                        <?=
                        Html::dropDownList('', $skin, array_combine($skins, $skins), [
                            'id' => 'select-skin', 'class' => 'form-control'
                        ]);
                        ?>
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
                    <div class="sidebar-form">
                        <?=
                        PageStat::widget([
                            'options' => ['class' => 'form-control'],
                            'template' => Html::a('{num} Hit', ['/page-statistic/index']),
                        ])
                        ?>
                    </div>
                </section>
            </aside>
            <div class="content-wrapper">
<?= $content; ?>
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12">
<?= Disqus::widget() ?>
                        </div>
                    </div>
                </section>
            </div>

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    Version 2.0
                </div>
                <strong>Copyright &copy; <?= date('Y') ?> <a href="#">Deesoft</a>.</strong> All rights reserved.
            </footer>
        </div>
<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
