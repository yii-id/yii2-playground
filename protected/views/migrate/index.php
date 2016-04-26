<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$migrations = [
    'up' => 'Upgrades the application by applying new migrations.',
    'down' => 'Downgrades the application by reverting old migrations.',
    'redo' => 'Redoes the last few migrations.'
];
$this->title = 'Migration';
?>
<div class="default-index">
    <div class="page-header">
        <h1>Welcome to Migration GUI <small>a magical tool that can manages application migrations for you</small></h1>
    </div>

    <p class="lead">Start the fun with the following migration:</p>

    <div class="row">
        <?php foreach ($migrations as $id => $description): ?>
            <div class="generator col-lg-4">
                <h3><?= Html::encode($id) ?></h3>
                <p><?= $description ?></p>
                <p><?= Html::a('Start &raquo;', ['run', 'id' => $id], ['class' => 'btn btn-default']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>

</div>
