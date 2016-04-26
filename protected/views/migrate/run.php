<?php

use yii\web\View;
use yii\helpers\Html;

/* @var $this View */
$this->registerJs($this->render('_script.js'));
$this->title = 'Migrate ' . $id;
$this->params['breadcrumbs'][] = ['label' => 'Migrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>migrate/<?= $id ?></h1>
<?= Html::beginForm() ?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th >Migrations</th>
                    <th style="width: 40px;"><input type="checkbox" id="check-all"></th>
                </tr>
            </thead>
            <tbody id="migration-list">
                <?php foreach ($migrations as $migration): ?>
                    <tr>
                        <td><?= $migration ?></td>
                        <td><?=
                            Html::checkbox('migrations[]', false, [
                                'class' => 'check',
                                'value' => substr($migration, 1, 13)])
                            ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <?= Html::submitButton('Execute', ['class' => $id == 'up' ? 'btn btn-success' : 'btn btn-danger']) ?>
    </div>
    <div class="col-md-12">
        <?= isset($result) ? "<pre>{$result}</pre>" : '' ?>
    </div>
</div>
<?= Html::endForm(); ?>
