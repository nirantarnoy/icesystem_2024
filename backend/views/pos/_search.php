<?php

use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$dash_date = null;
$trigger_submit = 0;
if ($model->order_date != null) {
    $trigger_submit = 0;
    //$dash_date = date('d/m/Y', strtotime($model->f_date)) . ' - ' . date('d/m/Y', strtotime($model->t_date));
} else {
    $model->order_date = date('d/m/Y') . '-' . date('d/m/Y');
    $trigger_submit = 1;
}

$company_id = 0;
$branch_id = 0;

if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id= \Yii::$app->user->identity->branch_id;
}

//echo $dash_date;
?>

<div class="position-search">
    <input type="hidden" id="check-is-init" value="<?= $trigger_submit ?>">
    <?php $form = ActiveForm::begin([
        'action' => ['salehistory'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="input-group">
        <!--         <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>-->
        <?= $form->field($model, 'globalSearch')->textInput(['placeholder' => 'ค้นหา', 'class' => 'form-control', 'aria-describedby' => 'basic-addon1'])->label(false) ?>
        <?php $model->created_by = $model->created_by == null ? \Yii::$app->user->id : $model->created_by ?>
        <?= $form->field($model, 'created_by')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(\backend\models\User::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all(), 'id', function ($data) {
                return $data->username;
            }),
            'options' => [
                'placeholder' => '--เลือกพนักงาน--',
                'style'=>['width: 450px;'],
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(false) ?>
        <?php //echo $form->field($model, 'order_date')->widget(\kartik\daterange\DateRangePicker::className(), [
//            'value' => $dash_date,
//            'pluginOptions' => [
//                'format' => 'DD/MM/YYYY',
//                'locale' => [
//                    'format' => 'DD/MM/YYYY'
//                ],
//            ],
//            'presetDropdown' => true,
//            'options' => [
//                'id' => 'search-date',
//                'class' => 'form-control',
//                'onchange' => '$("#form-dashboard").submit();'
//            ],
//        ])->label(false) ?>
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
              //  'onchange' => 'this.form.submit();',
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
        <span style="margin-left: 2px;"></span>
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
              //  'onchange' => 'this.form.submit();',
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
        <span style="margin-left: 10px;"> <button type="submit" class="btn btn-primary btn-find-data">ค้นหา</button></span>

    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = <<<JS
$(function(){
   var x = $("#check-is-init").val();
   if(x == 1){
       $("#search-date").trigger('change');
   }
});
JS;
$this->registerJs($js, static::POS_END);
?>
