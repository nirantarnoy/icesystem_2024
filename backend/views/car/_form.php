<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use softark\duallistbox\DualListbox;

$company_id = 1;
$branch_id = 1;
if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id = \Yii::$app->user->identity->branch_id;
}

?>

<div class="car-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-5">
            <?= $form->field($model, 'car_type_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Cartype::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => '--เลือกประเภทรถ--'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ]) ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model, 'sale_group_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Salegroup::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => '--เลือกกลุ่มการขาย--'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ]) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-5">
            <?= $form->field($model, 'sale_com_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Salecom::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => '--เลือกกลุ่มคอมมิชชั่น--'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ]) ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model, 'sale_com_extra')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Salecomcon::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => '--เลือกกลุ่มเงื่อนไขพิเศษ--'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ]) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-5">
            <?= $form->field($model, 'plate_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model, 'total_meter')->textInput(['maxlength' => true,'readonly'=>'readonly']) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?php //echo $form->field($model, 'shop_photo')->fileInput(['maxlength' => true]) ?>
            <br>
            <?php if ($model->photo != ''): ?>
                <div class="row">

                    <div class="col-lg-4">
                        <img src="../web/uploads/images/car/<?= $model->photo ?>" width="100%" alt="">
                    </div>
                    <div class="col-lg-4"></div>
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
                        <?= $form->field($model, 'photo')->fileInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <label for=""><?= $model->getAttributeLabel('status') ?></label>
            <?php echo $form->field($model, 'status')->widget(\toxor88\switchery\Switchery::className(), ['options' => ['label' => '', 'class' => 'form-control']])->label(false) ?>
        </div>
        <div class="col-lg-1"></div>
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

    <hr>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <h4>พนักงานประจำรถ</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?php
            $options = [
                'multiple' => true,
                'size' => 20,
            ];
            // echo Html::listBox($name, $selection, $items, $options);
            $model->emp_id = $emp_select_list;
            echo $form->field($model, 'emp_id')->widget(DualListbox::className(), [
                'items' => \yii\helpers\ArrayHelper::map(\backend\models\Employee::find()->all(), 'id', function ($data) {
                    return $data->fname . ' ' . $data->lname;
                }),
                'options' => $options,
                'clientOptions' => [
                    'moveOnSelect' => false,
                    'selectedListLabel' => 'รายการที่เลือก',
                    'nonSelectedListLabel' => 'พนักงานทั้งหมด',
                    'filterPlaceHolder' => 'ค้นหารายชื่อพนักงาน',
                    'infoTextEmpty' => 'ไม่มีรายการที่เลือก',
                    'infoText' => 'รายการทั้งหมด {0}'
                ],
            ])->label(false);
            ?>
        </div>
        <div class="col-lg-1"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<form id="form-delete-photo" action="<?= \yii\helpers\Url::to(['car/deletephoto'], true) ?>" method="post">
    <input type="hidden" class="delete-photo-id" name="delete_id" value="">
</form>
<?php
$js = <<<JS
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

$this->registerJs($js, static::POS_END);

?>
