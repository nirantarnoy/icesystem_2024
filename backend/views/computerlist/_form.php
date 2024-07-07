<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$company_id = 0;
$branch_id = 0;

if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id = \Yii::$app->user->identity->branch_id;
}
?>

<div class="computerlist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'computer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mac_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ip_address')->textInput(['maxlength' => true]) ?>

    <?php
      $model->userid = explode(',',$model->userid);
    ?>
    <?= $form->field($model, 'userid')->widget(\kartik\select2\Select2::className(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\User::find()->where(['status' => 1, 'company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', 'username'),
        'options' => [
            'placeholder' => 'เลือก'
        ],
        'pluginOptions' => [
            'multiple' => true,
        ]
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
