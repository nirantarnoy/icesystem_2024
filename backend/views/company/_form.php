<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'engname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'taxid')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'address')->textarea() ?>

            <?php if ($model->logo != ''): ?>
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <img src="../web/uploads/images/company/<?= $model->logo ?>" width="100%" alt="">
                    </div>
                    <div class="col-lg-4"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <div class="btn btn-danger btn-delete-photo" data-var="<?= $model->id ?>">ลบรูปภาพ</div>
                    </div>
                    <div class="col-lg-4"></div>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-lg-4">
                        <?= $form->field($model, 'logo')->fileInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-lg-4"></div>
                </div>
            <?php endif; ?>

            <label for=""><?= $model->getAttributeLabel('status') ?></label>
            <?php echo $form->field($model, 'status')->widget(\toxor88\switchery\Switchery::className(), ['options' => ['label' => '', 'class' => 'form-control']])->label(false) ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <h4>สาขา</h4>
            <br/>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="width: 5%;text-align: center">#</th>
                    <th style="width: 15%">รหัส</th>
                    <th>ชื่อ</th>
                    <th style="width: 15%;text-align: center">-</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($model_branch != null): ?>
                    <?php $i = 0; ?>
                    <?php foreach ($model_branch as $value): ?>
                        <?php $i += 1; ?>
                        <tr>
                            <td style="text-align: center"><?= $i ?></td>
                            <td><?= \backend\models\Branch::findCode($value->id) ?></td>
                            <td><?= \backend\models\Branch::findName($value->id) ?></td>
                            <td style="text-align: center;">
                                <a href="<?=\yii\helpers\Url::to(['branch/view','id'=>$value->id],true)?>" class="btn btn-info">ดูรายละเอียด</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<form id="form-delete-photo" action="<?=\yii\helpers\Url::to(['company/deletephoto'], true)?>" method="post">
    <input type="hidden" class="delete-photo-id" name="delete_id" value="">
</form>
<?php
//$url_to_delete_photo = \yii\helpers\Url::to(['product/deletephoto'], true);
$js = <<<JS
  $(function(){
     $(".btn-delete-photo").click(function (){
        var prodid = $(this).attr('data-var');
      //  alert(prodid);
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
  });
JS;
$this->registerJs($js, static::POS_END);
?>
