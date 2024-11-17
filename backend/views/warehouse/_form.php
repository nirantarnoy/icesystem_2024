<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="warehouse-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/data']]); ?>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?= $form->field($model, 'company_id')->Widget(\kartik\select2\Select2::className(),[
                'data'=>\yii\helpers\ArrayHelper::map(\backend\models\Company::find()->all(),'id','name'),
                'options'=>[
                    'placeholder'=>'--เลือกบริษัท--',
                    'onchange'=>'showbranch($(this))',
                ]
            ]) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?= $form->field($model, 'branch_id')->Widget(\kartik\select2\Select2::className(),[
                'data'=>\yii\helpers\ArrayHelper::map(\backend\models\Branch::find()->all(),'id','name'),
                'options'=>[
                        'class'=>'warehouse-branc-id',
                    'placeholder'=>'--เลือกสาขา--'
                ]
            ]) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <?= $form->field($model, 'photo')->fileInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-3">
            <label for=""><?= $model->getAttributeLabel('status') ?></label>
            <?php echo $form->field($model, 'status')->widget(\toxor88\switchery\Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label(false) ?>
        </div>
        <div class="col-lg-8">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-3">
            <label for=""><?= $model->getAttributeLabel('is_primary') ?></label>
            <?php echo $form->field($model, 'is_primary')->widget(\toxor88\switchery\Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label(false) ?>
        </div>
        <div class="col-lg-3">
            <label for=""><?= $model->getAttributeLabel('is_reprocess') ?></label>
            <?php echo $form->field($model, 'is_reprocess')->widget(\toxor88\switchery\Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label(false) ?>
        </div>
        <div class="col-lg-3">
            <label for=""><?= $model->getAttributeLabel('is_warehouse_car') ?></label>
            <?php echo $form->field($model, 'is_warehouse_car')->widget(\toxor88\switchery\Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label(false) ?>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-lg-1"></div>
    </div>



    <?php ActiveForm::end(); ?>

</div>

<?php
$url_to_show_branch = \yii\helpers\Url::to(['warehouse/findbranch'],true);
$js=<<<JS
$(function(){
    //alert();
});

function showbranch(e){
    var com_id = e.val();
    if(com_id){
             $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_show_branch",
              'data': {'com_id': com_id},
              'success': function(data) {
                 // alert(data);
                 $(".warehouse-branc-id").html(data);
                 }
              });
    }
     
}
JS;
$this->registerJs($js,static::POS_END);
?>
