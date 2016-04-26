<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mdm\widgets\GridInput;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'number')->textInput(['readonly' => true]) ?>

    <?=
    $form->field($model, 'Date')->widget(\yii\jui\DatePicker::className(), [
        'dateFormat' => 'php:d-m-Y',
        'options' => ['class' => 'form-control']
    ])
    ?>

    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?=
        Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success'
                    : 'btn btn-primary'])
        ?>
    </div>
    <div class="form-group">
        <?=
        GridInput::widget([
            'allModels' => $model->orderItems,
            'model' => \app\models\OrderItem::className(),
            'form' => $form,
            'columns' => [
                ['class' => 'mdm\widgets\SerialColumn'],
                'product',
                'qty',
                ['class' => 'mdm\widgets\ButtonColumn']
            ],
            'hiddens' => [
                'id'
            ]
        ])
        ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
