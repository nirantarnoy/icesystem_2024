<?php

use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$dash_date = null;
//$trigger_submit = 0;
//if ($model->order_date != null) {
//    $trigger_submit = 0;
//    //$dash_date = date('d/m/Y', strtotime($model->f_date)) . ' - ' . date('d/m/Y', strtotime($model->t_date));
//} else {
//    $model->order_date = date('d/m/Y') . '-' . date('d/m/Y');
//    $trigger_submit = 1;
//}

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
    <?php $form = ActiveForm::begin([
        'action' => ['dailysum'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>


        <div class="row">
            <div class="col-lg-3">
                <div class="label">
                    ค้นหาจากรหัสสินค้า
                </div>
                <div class="input-group">
                    <?php
                    echo \kartik\select2\Select2::widget([
                            'model' => $model,
                        'attribute'=>'product_id',
                        'data' => \yii\helpers\ArrayHelper::map(\backend\models\Product::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all(),'id','code'),
                        //'value' => $product_id,
                        'options' => [
                            'placeholder' => 'เลือกสินค้า',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ]
                    ]);
                    ?>
                </div>

            </div>
            <div class="col-lg-3">
                <div class="label">
                    ตั้งแต่วันที่
                </div>
                <div class="input-group">
                    <?php
                    echo DateRangePicker::widget([
                        'model' => $model,
                        'attribute' => 'from_date',
                       // 'name' => 'from_date',
                       // 'value'=> $from_date_time,
                        //    'useWithAddon'=>true,
                        'convertFormat'=>true,
                        'options' => [
                            'class' => 'form-control',
                            'placeholder'=>'ตั้งแต่วันที่',
                            // 'onchange' => 'this.form.submit();',
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
            <div class="col-lg-3">
                <div class="label">
                    วันที่
                </div>
                <div class="input-group">
                    <?php
                    echo DateRangePicker::widget([
                        'model' => $model,
                        'attribute' => 'to_date',
//                        'name' => 'to_date',
//                        'value'=> $to_date_time,
                        //    'useWithAddon'=>true,
                        'convertFormat'=>true,
                        'options' => [
                            'class' => 'form-control',
                            'placeholder'=>'ถึงวันที่',
                            // 'onchange' => 'this.form.submit();',
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
            <div class="col-lg-2">
                <div class="label">พนักงาน</div>
                <?php
                echo \kartik\select2\Select2::widget([
                    'model' => $model,
                    'attribute' => 'emp_id',
                   // 'name'=>'emp_id',
                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\User::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all(),'id','username'),
                    //'value' => $emp_value,
                    'options' => [
                        'placeholder' => 'เลือกพนักงาน',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]);
                ?>
            </div>
<div class="col-lg-1">
    <div class="label" style="color: white">
        ต้นหา
    </div>
    <span style="margin-left: 10px;"> <button
                type="submit"
                class="btn btn-primary btn-find-data">ค้นหา</button></span>
</div>
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
