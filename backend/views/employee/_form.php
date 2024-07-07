<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$company_id = 1;
$branch_id = 1;
if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id = \Yii::$app->user->identity->branch_id;
}
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'lname')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'gender')->Widget(\kartik\select2\Select2::className(),[
                'data'=>\yii\helpers\ArrayHelper::map(\backend\helpers\GenderType::asArrayObject(),'id','name'),
                'options'=>[
                    'placeholder'=>'--เลือกเพศ--'
                ]
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'position')->Widget(\kartik\select2\Select2::className(),[
                'data'=>\yii\helpers\ArrayHelper::map(\backend\models\Position::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all(),'id','name'),
                'options'=>[
                    'placeholder'=>'--เลือกตำแหน่ง--'
                ]
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'salary_type')->Widget(\kartik\select2\Select2::className(),[
                'data'=>\yii\helpers\ArrayHelper::map(\backend\helpers\SalaryType::asArrayObject(),'id','name'),
                'options'=>[
                    'placeholder'=>'--เลือกประเภทเงินเดือน--'
                ]
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'emp_start')->widget(\kartik\date\DatePicker::className(),[
                    'value' => date('d/m/Y')
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?php echo $form->field($model, 'is_com_cal')->widget(\toxor88\switchery\Switchery::className(), ['options' => ['label' => '', 'class' => 'form-control']])->label() ?>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-4">
            <?php echo $form->field($model, 'is_sale_operator')->widget(\toxor88\switchery\Switchery::className(), ['options' => ['label' => '', 'class' => 'form-control']])->label() ?>

        </div>
        <div class="col-lg-4">
            <?php echo $form->field($model, 'status')->widget(\toxor88\switchery\Switchery::className(), ['options' => ['label' => '', 'class' => 'form-control']])->label() ?>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <br>
            <?php if ($model->photo != ''): ?>
                <div class="row">

                    <div class="col-lg-4">
                        <img src="../web/uploads/images/employee/<?= $model->photo ?>" width="100%" alt="">
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="btn btn-danger btn-delete-photo" data-var="<?= $model->id ?>">ลบรูปภาพ</div>
                    </div>
                    <div class="col-lg-4"></div>
                </div>
            <?php else: ?>
                <div class="row">

                    <div class="col-lg-4">
                        <?= $form->field($model, 'photo')->fileInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <br>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<form id="form-delete-photo" action="<?=\yii\helpers\Url::to(['employee/deletephoto'], true)?>" method="post">
    <input type="hidden" class="delete-photo-id" name="delete_id" value="">
</form>
<?php
$js=<<<JS
$(function(){
    
});
$(".btn-delete-photo").click(function (){
        var prodid = $(this).attr('data-var');
       //alert(prodid);
      swal({
                title: "ต้องการทำรายการนี้ใช่หรือไม่",
                text: "",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
                showLoaderOnConfirm: true
               }, function () {
                  $(".delete-photo-id").val(prodid);
                  $("#form-delete-photo").submit();
         });
     });
JS;

$this->registerJs($js,static::POS_END);

?>
