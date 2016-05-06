<?php

use yii\web\View;
use yii\helpers\Url;

/* @var $this View */
?>
<header class="main-header">
    <a href="<?= Yii::$app->homeUrl ?>" class="logo">
        <!-- LOGO -->
        Yii2 Playground
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
                    <a href="<?= Url::to(['/chat/index']) ?>" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span data-toggle="tooltip" title=""  class="label label-success" id="msg-notif"></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>