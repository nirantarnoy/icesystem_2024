<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CardailySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cardaily-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="form-inline">
        <?= $form->field($model, 'route_id')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->all(), 'id', 'name'),
            'options' => [
                'id' => 'route-id',
                'placeholder' => '--ค้นหาสายส่ง--'
            ],
            'pluginOptions' => [
                'allowClear' => true
            ]
        ])->label('สายส่ง') ?>
        <?= $form->field($model, 'car_name')->textInput(['class' => 'form-control', 'style' => 'margin-left:5px;margin-right:5px;', 'autocomplete' => 'off', 'placeholder' => 'ชื่อรถ หรือ รหัสรถ'])->label('ค้นหารถ') ?>
        
        <?php $model->trans_date = $model->trans_date == null ? date('d/m/Y') : date('d/m/Y', strtotime($model->trans_date)); ?>
        <?= $form->field($model, 'trans_date')->widget(\kartik\date\DatePicker::className(), [
            'options' => [
                'id' => 'car-trans-date'
            ],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
        ])->label(false) ?>

        <?php if($model->has_driver == null) $model->has_driver = 1; ?>
        <span style="margin-left: 5px;"></span>
        <?= $form->field($model, 'has_driver')->widget(\kartik\select2\Select2::className(), [
            'data' => [1 => 'มีคนขับ', 2 => 'ไม่มีคนขับ', 0 => 'ทั้งหมด'],
            'options' => [
                'placeholder' => '--แสดง--',
                'onchange' => 'this.form.submit();',
            ],
            'pluginOptions' => [
                'width' => '150px'
            ]
        ])->label(false) ?>

        <button type="submit" class="btn btn-primary btn-search" style="margin-left: 5px;"><i class='fa fa-search'></i> ค้นหา
        </button>

        <?php ActiveForm::end(); ?>
    </div>
</div>
