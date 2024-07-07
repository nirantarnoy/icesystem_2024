<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

?>

<div class="paymentreceive-search">

    <?php $form = ActiveForm::begin([
        'action' => ['customerloan'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-lg-3">
            <div class="label">สายส่ง</div>
            <?= $form->field($model, 'car_selected')->widget(Select2::className(), [
                'data' => ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', 'code'),
                'options' => [
                    'placeholder' => 'เลือกสายส่ง',
                    'multiple' => true,
                    'onchange'=>'getcustomer($(this))',
                ],
                // 'theme' => \kartik\select2\Select2::THEME_KRAJEE,
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ])->label(false) ?>
        </div>
        <div class="col-lg-3">
            <div class="label">ลูกค้า</div>
            <?= $form->field($model, 'customer_selected')->widget(Select2::className(), [
                'data' => ArrayHelper::map(\backend\models\Customer::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', 'name'),
                'options' => [
                        'id'=>'customer-select',
                    'placeholder' => 'เลือกลูกค้า',
                    'multiple' => true
                ],
                // 'theme' => \kartik\select2\Select2::THEME_KRAJEE,
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ])->label(false) ?>
        </div>
        <div class="col-lg-3">
            <div class="label" style="color: white">ค้นหา</div>
            <input type="submit" class="btn btn-primary" value="ค้นหา">
        </div>
        <div class="col-lg-3"></div>
    </div>
    <div class="input-group">
        <!--         <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>-->

    </div>
    <?php ActiveForm::end(); ?>

</div>
