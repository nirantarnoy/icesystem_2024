<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Deviceregister */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deviceregister-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'device_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'brand_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model_name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->widget(\toxor88\switchery\Switchery::className(),['options'=>['label'=>'','class'=>'form-control']]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
