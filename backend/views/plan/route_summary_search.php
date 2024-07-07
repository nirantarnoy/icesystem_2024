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
        'action' => ['routesummary'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>


    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'route_id')->widget(\kartik\select2\Select2::className(), [
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
