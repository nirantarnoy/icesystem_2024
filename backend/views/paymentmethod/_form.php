<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="paymentmethod-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-1">

        </div>
        <div class="col-lg-10">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'pay_type')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\helpers\PayType::asArrayObject(), 'id', 'name'),
                'options' => [
                    'id' => 'pay-type',
                ]
            ])->label('หมวดหมู่') ?>

            <?php echo $form->field($model, 'note')->textarea(['maxlength' => true]) ?>

            <label for=""><?= $model->getAttributeLabel('status') ?></label>
            <?php echo $form->field($model, 'status')->widget(\toxor88\switchery\Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label(false) ?>
            <br>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
