<?php

use yii\web\View;
use yii\base\DynamicModel;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/* @var $this View */

$model = new DynamicModel(['verifyCode']);
$model->addRule('verifyCode', 'captcha')
    ->addRule('verifyCode', 'required');

$valid = false;
if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
    $valid = true;
}
?>
<?php if ($valid): ?>
    <h1>OK Gan...</h1>
    <?= Html::a('Back', '', ['class' => 'btn btn-success']) ?>
<?php else: ?>
    <?php $form = ActiveForm::begin() ?>
    <?=
    $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-12">{image}</div>'
        . '<div class="col-lg-12">{input}</div></div>',
    ])
    ?>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php endif;