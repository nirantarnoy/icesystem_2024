<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerinvoiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customerinvoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'globalSearch')->textInput(['placeholder'=>'ค้นหา','class'=>'form-control','aria-describedby'=>'basic-addon1'])->label(false) ?>
        </div>
        <div class="col-lg-2">
            <?= \kartik\daterange\DateRangePicker::widget([
                'model' => $model,
                'attribute' => 'from_date',
                'convertFormat' => true,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'จากวันที่',
                    'autocomplete' => 'off',
                ],
                'pluginOptions' => [
                    'locale' => [
                        'format' => 'Y-m-d',
                    ],
                    'singleDatePicker' => true,
                    'showDropdowns' => true,
                ]
            ]) ?>
        </div>
        <div class="col-lg-2">
            <?= \kartik\daterange\DateRangePicker::widget([
                'model' => $model,
                'attribute' => 'to_date',
                'convertFormat' => true,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'ถึงวันที่',
                    'autocomplete' => 'off',
                ],
                'pluginOptions' => [
                    'locale' => [
                        'format' => 'Y-m-d',
                    ],
                    'singleDatePicker' => true,
                    'showDropdowns' => true,
                ]
            ]) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'status')->dropDownList([0 => 'ไม่จบงาน', 100 => 'จบงาน'], ['prompt' => '-- ผลการจบงาน --'])->label(false) ?>
        </div>
        <div class="col-lg-3">
            <?= Html::submitButton('ค้นหา', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('รีเซ็ต', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
