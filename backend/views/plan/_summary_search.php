<?php

use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PlanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['calsummary'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>



    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'globalSearch')->textInput(['placeholder'=>'ค้นหา','class'=>'form-control','aria-describedby'=>'basic-addon1'])->label(false) ?>
        </div>
        <div class="col-lg-4">
            <?php
            echo \kartik\date\DatePicker::widget([
                'model' => $model,
                'attribute' => 'from_date',
                'options' => [
                    'placeholder' => 'ตั้งแต่วันที่',
                    'template' => '{widget}{error}',
                    'class' => 'form-control',
                    'autocomplete' => 'off',
                    'onchange' => 'this.form.submit();',
                ],
                // 'type'=> \kartik\date\DatePicker::TYPE_INPUT,
                'pluginOptions' => [
                    'todayHighlight' => true,
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]);
            ?>
        </div>
        <div class="col-lg-4">
            <?php
            echo \kartik\date\DatePicker::widget([
                'model' => $model,
                'attribute' => 'to_date',
                'options' => [
                    'placeholder' => 'ถึงวันที่',
                    'template' => '{widget}{error}',
                    'class' => 'form-control',
                    'autocomplete' => 'off',
                    'onchange' => 'this.form.submit();',
                ],
                // 'type'=> \kartik\date\DatePicker::TYPE_INPUT,
                'pluginOptions' => [
                    'todayHighlight' => true,
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]);
            ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
