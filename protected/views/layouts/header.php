<?php

use yii\web\View;
use yii\helpers\Url;

/* @var $this View */
?>
<header class="main-header">
    <a href="<?= Yii::$app->homeUrl ?>" class="logo">
        <!-- LOGO -->
        <span class="logo-mini"><b>Yii</b>2</span>
        <span class="logo-lg">Yii2 Playground</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <?php if (Yii::$app->getUser()->getIsGuest()): ?>
                        <a href="<?= Url::to(['/user/login']) ?>" aria-expanded="false">
                            <i class="fa fa-user"></i>
                            <span >Login</span>
                        </a>
                    <?php else: ?>
                        <a href="<?= Url::to(['/user/logout']) ?>" aria-expanded="false" data-method="POST">
                            <i class="fa fa-user"></i>
                            <span >Logout (<?= Yii::$app->getUser()->identity->username ?>)</span>
                        </a>
                    <?php endif; ?>
                </li>
                <li>
                    <a href="<?= Url::to(['/chat/index']) ?>" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span data-toggle="tooltip" title=""  class="label label-success" id="msg-notif"></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>