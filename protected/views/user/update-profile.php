<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\ar\UserProfile */

$this->title = 'Update Profile';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs($this->render('_update-profile.js'));
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-profile', 'options' => ['enctype' => 'multipart/form-data']]); ?>
            <?= $form->field($model, 'fullname') ?>
            <div class="form-group">
                <?=
                Html::img(['/file','id'=>$model->photo_id], [
                    'id' => 'img', 'class' => 'form-control',
                    'style' => ['min-height' => '150px', 'height' => 'auto']])
                ?>
            </div>
            <?= $form->field($model, 'file')->fileInput(['id' => 'img-inp']) ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
