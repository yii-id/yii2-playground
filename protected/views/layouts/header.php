<?php

use yii\web\View;
use yii\helpers\Url;

/* @var $this View */
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js');
$this->registerJs($this->render('notif.js'), View::POS_END);
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
                
                <li class="dropdown notifications-menu" id="notif-push">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-info" v-if="msgs.length">{{msgs.length}}</span>
                    </a>
                    <ul class="dropdown-menu" v-if="msgs.length">
                        <li class="header">You have {{msgs.length}} notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;">
                                <ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                                    <li v-for="(index, msg) in msgs">
                                        <a href="#" v-on:click="read(index)">
                                            <i class="fa fa-envelope text-aqua"></i> {{msg}}
                                        </a>
                                    </li>
                                </ul>
                                <div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div>
                                <div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
                            </div>
                        </li>
                        <li class="footer"><a href="#" v-on:click="readAll">Read all</a></li>
                    </ul>
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
