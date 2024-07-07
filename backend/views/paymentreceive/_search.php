<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$company_id = 0;
$branch_id = 0;

if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id= \Yii::$app->user->identity->branch_id;
}
?>

<div class="paymentreceive-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>


    <div class="input-group">
        <!--         <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>-->
        <?= $form->field($model, 'globalSearch')->textInput(['placeholder' => 'ค้นหา', 'class' => 'form-control', 'aria-describedby' => 'basic-addon1'])->label(false) ?>
        <?= $form->field($model, 'trans_date')->widget(\kartik\date\DatePicker::className(),[
                'options' => [
                    'autocomplete'=> 'off',
                ],
                'pluginOptions' => [
                    'format'=>'dd/mm/yyyy',
                ]
        ])->label(false) ?>
        <?= $form->field($model, 'route_id')->widget(\kartik\select2\Select2::className(),[
                'data'=> \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all(),'id','name'),
                 'options' => [
                         'placeholder'=>'เลือกสายส่ง',
                         'style'=>'margin-left: 5px;',
                 ],
            'pluginOptions' => [
                    'allowClear'=> true,
            ]
        ])->label(false) ?>
        <button type="submit" class="btn btn-primary btn-sm" style="height: 40px;margin-left:5px;">ค้นหา</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
