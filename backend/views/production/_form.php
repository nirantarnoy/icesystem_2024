<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Production */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="production-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'prod_no')->textInput(['maxlength' => true,'readonly'=>'readonly']) ?>

    <?= $form->field($model, 'prod_date')->textInput() ?>

    <?= $form->field($model, 'plan_id')->textInput(['value'=>$model->isNewRecord?'':\backend\models\Plan::findNo($model->plan_id),'readonly'=>'readonly']) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'delivery_route_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
