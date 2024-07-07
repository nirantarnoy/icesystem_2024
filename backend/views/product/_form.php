<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

$company_id = 1;
$branch_id = 1;
if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id = \Yii::$app->user->identity->branch_id;
}

$unit_data = \backend\models\Unit::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all();
$prod_group_data = \backend\models\Productgroup::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all();
$prod_type_data = \backend\models\Producttype::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->all();
$prod_status = \backend\helpers\ProductStatus::asArrayObject();
//print_r($prod_status);

$sale_status_data = [['id' => 1, 'name' => 'ขาย'], ['id' => 2, 'name' => 'ไม่ขาย']];
$stock_type_data = [['id' => 1, 'name' => 'ตัดสต๊อก'], ['id' => 2, 'name' => 'ไม่ตัดสต๊อก']];

?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <label for=""><?= $model->getAttributeLabel('product_type_id') ?></label>
            <select name="product_type_id" class="form-control product-type-id" id=""
                    onchange="">
                <option value="0">--เลือกประเภทสินค้า-</option>
                <?php foreach ($prod_type_data as $val2): ?>
                    <?php
                    $selected = '';
                    if ($val2->id == $model->product_type_id)
                        $selected = 'selected';
                    ?>
                    <option value="<?= $val2->id ?>" <?= $selected ?>><?= $val2->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-4">
            <label for=""><?= $model->getAttributeLabel('product_group_id') ?></label>
            <select name="product_group_id" class="form-control product-group-id" id=""
                    onchange="">
                <option value="0">--เลือกกลุ่มสินค้า-</option>
                <?php foreach ($prod_group_data as $val2): ?>
                    <?php
                    $selected = '';
                    if ($val2->id == $model->product_group_id)
                        $selected = 'selected';
                    ?>
                    <option value="<?= $val2->id ?>" <?= $selected ?>><?= $val2->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-4">
            <label for=""><?= $model->getAttributeLabel('unit_id') ?></label>
            <select name="unit_id" class="form-control unit-id" id=""
                    onchange="">
                <option value="0">--เลือกหน่วยนับ-</option>
                <?php foreach ($unit_data as $val2): ?>
                    <?php
                    $selected = '';
                    if ($val2->id == $model->unit_id)
                        $selected = 'selected';
                    ?>
                    <option value="<?= $val2->id ?>" <?= $selected ?>><?= $val2->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-4">
            <label for=""><?= $model->getAttributeLabel('sale_status') ?></label>
            <select name="sale_status" class="form-control sale-status" id=""
                    onchange="">
                <?php for ($i = 0; $i <= count($sale_status_data) - 1; $i++): ?>
                    <?php
                    $selected = '';
                    if ($sale_status_data[$i]['id'] == $model->sale_status) {
                        $selected = 'selected';
                    }
                    ?>
                    <option value="<?= $sale_status_data[$i]['id'] ?>" <?= $selected ?>><?= $sale_status_data[$i]['name'] ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-lg-4">
            <label for=""><?= $model->getAttributeLabel('stock_type') ?></label>
            <select name="stock_type" class="form-control stock_type" id=""
                    onchange="">
                <?php for ($i = 0; $i <= count($stock_type_data) - 1; $i++): ?>
                    <?php
                    $selected = '';
                    if ($stock_type_data[$i]['id'] == $model->stock_type)
                        $selected = 'selected';
                    ?>
                    <option value="<?= $stock_type_data[$i]['id'] ?>" <?= $selected ?>><?= $stock_type_data[$i]['name'] ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-lg-4">
            <?php echo $form->field($model, 'is_pos_item')->widget(\toxor88\switchery\Switchery::className(), ['options' => ['label' => '', 'class' => 'form-control']])->label() ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'std_cost')->textInput() ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'sale_price')->textInput() ?>
        </div>

        <div class="col-lg-4">
            <label for=""><?= $model->getAttributeLabel('status') ?></label>
            <select name="status" class="form-control status" id=""
                    onchange="">
                <?php for ($i = 0; $i <= count($prod_status) - 1; $i++): ?>
                    <?php
                    $selected = '';
                    if ($prod_status[$i]['id'] == $model->status)
                        $selected = 'selected';
                    ?>
                    <option value="<?= $prod_status[$i]['id'] ?>" <?= $selected ?>><?= $prod_status[$i]['name'] ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'item_pos_seq')->textInput() ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'nw')->textInput()->label('น้ำหนักสินค้า') ?>
        </div>
        <div class="col-lg-4">
            <?php echo $form->field($model, 'stock_on_car')->widget(\toxor88\switchery\Switchery::className(), ['options' => ['label' => '', 'class' => 'form-control']])->label() ?>
        </div>
    </div>
    <hr style="border-top: 1px dashed black">
    <div class="row">
        <div class="col-lg-12">
            <label for="">แนบรูปสินค้า</label>
        </div>
    </div>
    <?php if ($model->photo != ''): ?>
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <img src="../web/uploads/images/products/<?= $model->photo ?>" width="100%" alt="">
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
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <?= $form->field($model, 'photo')->fileInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-4"></div>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<form id="form-delete-photo" action="<?= \yii\helpers\Url::to(['product/deletephoto'], true) ?>" method="post">
    <input type="hidden" class="delete-photo-id" name="delete_id" value="">
</form>

<?php
//$url_to_delete_photo = \yii\helpers\Url::to(['product/deletephoto'], true);
$js = <<<JS
  $(function(){
     // $(".product-type-id,.product-group-id").select2({
     //   'class': 'form-control'
     // });

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
  });
JS;
$this->registerJs($js, static::POS_END);
?>
