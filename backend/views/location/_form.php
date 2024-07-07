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

<div class="location-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/data']]); ?>
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <?= $form->field($model, 'warehouse_id')->Widget(\kartik\select2\Select2::className(),[
                'data'=>\yii\helpers\ArrayHelper::map(\backend\models\Warehouse::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all(),'id','name'),
                'options'=>[
                    'placeholder'=>'--เลือกคลังสินค้า--'
                ]
            ]) ?>
        </div>
        <div class="col-lg-1">
        </div>
    </div>
    <div style="height: 10px;"></div>
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
        <div class="col-lg-2">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>




    <?php ActiveForm::end(); ?>

</div>
