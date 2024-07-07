<?php

use kartik\daterange\DateRangePicker;
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

<div class="plan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['issuebyroute'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>


    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'delivery_route_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', function ($data) {
                    return $data->code . ' ' . $data->name;
                }),
                'options' => [
                    'placeholder' => '--เลือกสายส่ง--',
                    'onchange' => 'this.form.submit();'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '300px',
                    'multiple' => true,
                ]
            ])->label(false) ?>
        </div>
        <div class="col-lg-4">

            <?php
            echo DateRangePicker::widget([
                'model' => $model,
                'attribute' => 'from_date',
                //'name'=>'date_range_5',
                'value'=>'2015-10-19 12:00 AM',
                //    'useWithAddon'=>true,
                'convertFormat'=>true,
                'options' => [
                    'class' => 'form-control',
                    'placeholder'=>'ตั้งแต่วันที่',
                    'onchange' => 'this.form.submit();',
                    'autocomplete' => 'off',
                ],
                'pluginOptions'=>[
                    'timePicker'=>true,
                    'timePickerIncrement'=>1,
                    'locale'=>['format' => 'Y-m-d H:i'],
                    'singleDatePicker'=>true,
                    'showDropdowns'=>true,
                    'timePicker24Hour'=>true
                ]
            ]) ;
            ?>
        </div>
        <div class="col-lg-4">
            <?php
            echo DateRangePicker::widget([
                'model' => $model,
                'attribute' => 'to_date',
                //'name'=>'date_range_5',
                'value'=>'2015-10-19 12:00 AM',
                //    'useWithAddon'=>true,
                'convertFormat'=>true,
                'options' => [
                    'class' => 'form-control',
                    'placeholder'=>'ถึงวันที่',
                    'onchange' => 'this.form.submit();',
                    'autocomplete' => 'off',
                ],
                'pluginOptions'=>[
                    'timePicker'=>true,
                    'timePickerIncrement'=>1,
                    'locale'=>['format' => 'Y-m-d H:i'],
                    'singleDatePicker'=>true,
                    'showDropdowns'=>true,
                    'timePicker24Hour'=>true
                ]
            ]) ;
            ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
