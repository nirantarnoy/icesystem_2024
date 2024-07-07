<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$company_id = 1;
$brach_id = 1;
if(isset($_SESSION['user_company_id'])){
    $company_id = $_SESSION['user_company_id'];
}
if(isset($_SESSION['user_branch_id'])){
    $brach_id = $_SESSION['user_branch_id'];
}
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index2'],
        'method' => 'get',
        'options' => [
            'id' => 'form-order',
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="input-group">
                <!--         <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>-->
                <?= $form->field($model, 'globalSearch')->textInput(['placeholder' => 'เลขที่ขาย,รถ', 'class' => 'form-control', 'aria-describedby' => 'basic-addon1'])->label(false) ?>
                <?= $form->field($model, 'route_id')->widget(\kartik\select2\Select2::className(), [
                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['company_id'=>$company_id,'branch_id'=>$brach_id])->all(), 'id', function ($data) {
                        return $data->code . ' ' . $data->name;
                    }),
                    'options' => [
                        'placeholder' => '--เลือกสายส่ง--'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ])->label(false) ?>
                <?php $model->order_date = $model->order_date == null ? date('d/m/Y') : date('d/m/Y', strtotime($model->order_date)); ?>
                <?= $form->field($model, 'order_date')->widget(\kartik\date\DatePicker::className(), [
                    'value' => $model->order_date,
                    'options' => [
                        //   'onclick' => '$("form#form-order").submit()'
                    ],
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'todayHighlight' => true
                    ],
                ])->label(false) ?>

            </div>
        </div>
        <div class="col-lg-6">
            <button type="submit" class="btn btn-primary btn-search" style="margin-left: 5px;"><i
                        class='fa fa-search'></i> ค้นหา
            </button>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
