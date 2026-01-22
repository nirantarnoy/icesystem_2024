<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Customerrequest */
/* @var $form yii\widgets\ActiveForm */
$not_product = [15, 16, 98, 7, 8, 23];
$product_data = \common\models\Product::find()->where(['status' => 1])->andFilterWhere(['not in', 'id', $not_product])->orderBy(['item_pos_seq' => SORT_ASC])->all();
$attatch_doc_data = \common\models\CustomerRequestAttatchDoc::find()->where(['status' => 1])->all();
//$district_data = \backend\models\District::find()->all();
//$city_data = \backend\models\Amphur::find()->all();
//$province_data = \backend\models\Province::find()->all();

// Query ข้อมูล cus_req_standard ด้วย SQL Command
$cus_req_standard_sql = "SELECT * FROM cus_req_doc_standard ORDER BY id ASC";
$cus_req_standard_data = \Yii::$app->db->createCommand($cus_req_standard_sql)->queryAll();

// Query ข้อมูล cus_req_standard_item พร้อม join
$cus_req_standard_item_sql = "
    SELECT 
        csi.*,
        cs.name as standard_name 
    FROM cus_req_doc_standard_item csi 
    LEFT JOIN cus_req_doc_standard_item cs ON csi.cus_req_standard_id = cs.id 
    ORDER BY csi.cus_req_standard_id ASC, csi.id ASC
";
$cus_req_standard_item_data = \Yii::$app->db->createCommand($cus_req_standard_item_sql)->queryAll();

// Group items by standard_id
$grouped_items = [];
foreach ($cus_req_standard_item_data as $item) {
    $grouped_items[$item['cus_req_standard_id']][] = $item;
}


// Query ข้อมูลที่เคยเลือกไว้ (สำหรับ update mode)
$selected_items = [];
if (!$model->isNewRecord) {
    $selected_sql = "
        SELECT 
            cus_req_standard_id,
            cus_req_standard_item_id
        FROM cus_req_doc_standard_assign 
        WHERE cus_req_id = :cus_req_id
    ";
    $selected_data = \Yii::$app->db->createCommand($selected_sql)
        ->bindValue(':cus_req_id', $model->id)
        ->queryAll();

    // จัดเก็บเป็น array สำหรับเช็คง่ายๆ
    foreach ($selected_data as $selected) {
        $selected_items[$selected['cus_req_standard_id']][] = $selected['cus_req_standard_item_id'];
    }
}

?>

<?php
$this->registerCss('
#table-doc-checklist td {
    padding: 15px;
    border: 1px solid #dee2e6;
}

#table-doc-checklist .checkbox-inline {
    display: flex;
    align-items: center;
    margin: 0;
    padding: 5px;
    border-radius: 4px;
    transition: background-color 0.2s;
}

#table-doc-checklist .checkbox-inline:hover {
    background-color: #f8f9fa;
}

#table-doc-checklist .checkbox-inline input[type="checkbox"] {
    margin-right: 8px;
    margin-top: 0;
}

#table-doc-checklist .standard-item-checkbox:checked + label {
    font-weight: 500;
    color: #007bff;
}
');
?>

<div class="customerrequest-form">
    <!-- Flash Messages -->
    <?php if (\Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= \Yii::$app->session->getFlash('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (\Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= \Yii::$app->session->getFlash('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (\Yii::$app->session->hasFlash('warning')): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= \Yii::$app->session->getFlash('warning') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (\Yii::$app->session->hasFlash('info')): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <?= \Yii::$app->session->getFlash('info') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <!--    <div class="row">-->
    <!--        <div class="col-lg-12">-->
    <!--            <table class="table table-bordered" style="width: 100%;">-->
    <!--                <tr>-->
    <!--                    <td rowspan="2" style=";text-align: center;vertical-align: middle;">-->
    <!--                        <b>บันทึกการขาย (เปิดร้าน)</b>-->
    <!--                    </td>-->
    <!--                    <td style="width: 20%;">-->
    <!--                        เลขที่ :-->
    <!--                    </td>-->
    <!--                    <td style="width: 30%;">-->
    <!--                        -->
    <!--                    </td>-->
    <!--                </tr>-->
    <!--                <tr>-->
    <!--                    <td style="width: 20%;">-->
    <!--                        รหัสลูกค้า :-->
    <!--                    </td>-->
    <!--                    <td>-->
    <!--                        -->
    <!--                    </td>-->
    <!--                </tr>-->
    <!--            </table>-->
    <!--        </div>-->
    <!--    </div>-->

    <div class="row">
        <div class="col-lg-12">
            <h4><b>รายละเอียดลูกค้า</b></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3"><?= $form->field($model, 'journal_no')->textInput(['maxlength' => true, 'readonly' => 'readonly'])->label() ?></div>
        <div class="col-lg-3">
            <label for=""><?= $model->attributeLabels()['customer_ref_id'] ?></label>
            <input type="text" class="form-control"
                   value="<?= $model->isNewRecord ? '' : \backend\models\Customer::findCode($model->customer_ref_id) ?>"
                   readonly="readonly">
        </div>

    </div>
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'age')->textInput() ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'idcard_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'moo')->textInput() ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'district_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\District::find()->all(), 'DISTRICT_ID', 'DISTRICT_NAME'),
                'options' => ['placeholder' => 'เลือก', 'id' => 'selected-district'],
                'pluginOptions' => ['allowClear' => true],
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'city_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Amphur::find()->all(), 'AMPHUR_ID', 'AMPHUR_NAME'),
                'options' => ['placeholder' => 'เลือก', 'id' => 'selected-city', 'onchange' => 'getDistrict($(this))'],
                'pluginOptions' => ['allowClear' => true],
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'province_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Province::find()->all(), 'PROVINCE_ID', 'PROVINCE_NAME'),
                'options' => ['placeholder' => 'เลือก', 'onchange' => 'getCity($(this))'],
                'pluginOptions' => ['allowClear' => true],
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-3">
            <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
        </div>
<!--        <div class="col-lg-3">-->
<!--            <label for="">แนบเอกสาร</label>-->
<!--            <input type="file" id="add-doc-file" class="form-control" name="docfile[]" --><?php //=\backend\models\User::findName(\Yii::$app->user->id)=='iceadmin'?'': 'required' ?><!-- multiple accept="image/*">-->
<!--        </div>-->
<!--        <div class="col-lg-3">-->
<!--            <label for="">รูปหน้าร้าน</label>-->
<!--            <input type="file" id="add-shop-file" class="form-control" name="shopfile[]" --><?php //=\backend\models\User::findName(\Yii::$app->user->id)=='iceadmin'?'': 'required' ?><!-- multiple accept="image/*">-->
<!--        </div>-->

    </div>
    <div class="row">
        <div class="col-lg-12">
            <h4><b>รายละเอียดการขาย</b></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'route_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['status' => 1, 'branch_id' => 1])->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => '--เลือกรายการ--',
                ],
                'pluginOptions' => ['allowClear' => true],
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'route_num')->textInput() ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'start_date')->widget(\kartik\date\DatePicker::className(), ['options' => ['placeholder' => 'วันที่เริ่มต้น'], 'pluginOptions' => ['autoclose' => true, 'format' => 'dd/mm/yyyy']])->label('วันที่เริ่มต้น') ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'sale_price')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-8">
            <?php if ($model_doc != null): ?>
                <label for="">ตัวอย่างเอกสารแนบ</label>
                <div style="height: 10px;"></div>
                <?php foreach ($model_doc as $value): ?>
                    <a class="badge badge-primary"
                       href="<?= \Yii::$app->getUrlManager()->getBaseUrl() . '/uploads/files/customerrequest/' . $value->doc_name ?>"
                       target="_blank"><?= $value->doc_name ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h4><b>รายละเอียดการขาย</b></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table>
                <tr>
                    <?php $product_qty = null; ?>
                    <?php foreach ($product_data as $value): ?>
                        <?php if (!$model->isNewRecord) {
                            $product_qty = getRequestProductQty($model->id, $value->id);
                        }
                        ?>
                        <td>
                            <input type="hidden" name="product_id[]" value="<?= $value->id ?>">
                            <?= $value->name; ?> <input class="form-control" type="number" min="0" step="any"
                                                        name="product_qty[]" value="<?php echo $product_qty; ?>">
                        </td>
                    <?php endforeach; ?>
                </tr>
            </table>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-lg-2">
            <b>ปรเภทการขาย</b>
        </div>
        <div class="col-lg-10">
            <div class="row">
                <div class="col-lg-12">
                    <input type="checkbox"
                           class="payment-checkbox" <?php echo $model->payment_method_id == 1 ? 'checked' : ''; ?>
                           onclick="getPaymentType($(this))" value="1"> ขายสด เงินสด
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <input type="checkbox"
                           class="payment-checkbox" <?php echo $model->payment_method_id == 3 ? 'checked' : ''; ?>
                           onclick="getPaymentType($(this))" value="3"> ขายสด โอน บ/ช บจ.วรภัทร เลขที่
                    <u>764-3010880</u>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1">
                    <input type="checkbox"
                           class="payment-checkbox" <?php echo $model->payment_method_id == 2 ? 'checked' : ''; ?>
                           onclick="getPaymentType($(this))" value="2"> เครดิต
                </div>
                <div class="col-lg-1"><?= $form->field($model, 'credit_term')->textInput()->label(false) ?></div>
                <div class="col-lg-6">วัน โอน บ/ช บจ.วรภัทร เลขที่ <u>764-3002984</u></div>
                <div class="col-lg-2">หลังรับวางบิล</div>
                <div class="col-lg-1"><?= $form->field($model, 'after_invoice_day')->textInput()->label(false) ?></div>
                <div class="col-lg-1">วัน</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered" style="width: 100%" id="table-doc-checklist">
                <?php if (!empty($cus_req_standard_data)): ?>
                    <?php foreach ($cus_req_standard_data as $standard): ?>
                        <tr>
                            <!-- Column แรก: ชื่อหัวข้อจาก cus_req_standard -->
                            <td style="width: 200px; vertical-align: middle; font-weight: bold; background-color: #f8f9fa;">
                                <?= Html::encode($standard['name']) ?>
                            </td>

                            <!-- Columns ถัดไป: รายการ items พร้อม checkbox -->
                            <td>
                                <?php if (isset($grouped_items[$standard['id']])): ?>
                                    <div class="row">
                                    <?php foreach ($grouped_items[$standard['id']] as $index => $item): ?>
                                        <?php
                                        // ตรวจสอบว่าถูกเลือกไว้หรือไม่ (สำหรับ edit mode)
                                        $is_checked = false;
                                        if (!$model->isNewRecord) {
                                            // เช็คจาก array ที่เตรียมไว้
                                            if (isset($selected_items[$standard['id']]) &&
                                                in_array($item['id'], $selected_items[$standard['id']])) {
                                                $is_checked = true;
                                            }
                                        }
                                        ?>

                                        <div class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 10px;"><label
                                                    class="checkbox-inline" style="font-weight: normal;">
                                                <input type="checkbox"
                                                       name="standard_items[<?= $standard['id'] ?>][]"
                                                       value="<?= $item['id'] ?>"
                                                    <?= $is_checked ? 'checked' : '' ?>
                                                       class="standard-item-checkbox"
                                                       data-standard-id="<?= $standard['id'] ?>"
                                                       data-item-id="<?= $item['id'] ?>"
                                                       onchange="checkFileAttachment(this, 'photo_<?= $standard['id'] ?>_<?= $item['id'] ?>')">
                                                <?= Html::encode($item['name']) ?>
                                            </label>

                                            <!-- Photo upload สำหรับแต่ละ item -->
                                            <div class="photo-upload-section" style="margin-top: 5px;">
                                                <input type="file"
                                                       name="photo_<?= $standard['id'] ?>_<?= $item['id'] ?>[]"
                                                       id="photo_<?= $standard['id'] ?>_<?= $item['id'] ?>"
                                                       accept="image/*"
                                                       multiple
                                                       class="form-control form-control-sm"
                                                       style="font-size: 12px;"
                                                       disabled>

                                                <!-- แสดงรูปภาพที่มีอยู่แล้ว (ถ้ามี) -->
                                                <?php
                                                // Query existing photos for this combination
                                                if (!$model->isNewRecord) {
                                                    $existingPhotos = \Yii::$app->db->createCommand("
                                                    SELECT p.* FROM cus_req_doc_standard_assign_photo p
                                                    INNER JOIN cus_req_doc_standard_assign a ON p.cus_req_doc_standard_assign_id = a.id
                                                    WHERE a.cus_req_id = :cus_req_id 
                                                    AND a.cus_req_standard_id = :standard_id 
                                                    AND a.cus_req_standard_item_id = :item_id
                                                ")
                                                        ->bindValue(':cus_req_id', $model->id)
                                                        ->bindValue(':standard_id', $standard['id'])
                                                        ->bindValue(':item_id', $item['id'])
                                                        ->queryAll();
                                                } else {
                                                    $existingPhotos = [];
                                                }
                                                ?>

                                                <?php if (!empty($existingPhotos)): ?>
                                                    <div class="existing-photos-container" style="margin-top: 5px;">
                                                        <small class="text-muted">รูปภาพที่มีอยู่:</small>
                                                        <div class="photo-gallery"
                                                             style="display: flex; flex-wrap: wrap; gap: 5px; margin-top: 3px;">
                                                            <?php foreach ($existingPhotos as $photo): ?>
                                                                <div class="photo-item" style="position: relative;">
                                                                    <img src="<?= \Yii::getAlias('@web/uploads/customer-request-photos/' . $photo['photo']) ?>"
                                                                         alt="Photo"
                                                                         style="max-width: 60px; max-height: 60px; border: 1px solid #ddd; border-radius: 3px;">
                                                                    <button type="button"
                                                                            class="btn btn-danger btn-xs delete-photo"
                                                                            data-photo-id="<?= $photo['id'] ?>"
                                                                            style="position: absolute; top: -5px; right: -5px; padding: 1px 4px; font-size: 10px; line-height: 1;">
                                                                        ×
                                                                    </button>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <script>
                                                function checkFileAttachment(checkbox, fileInputId) {
                                                    const fileInput = document.getElementById(fileInputId);
                                                    if (checkbox.checked) {
                                                        fileInput.disabled = false;
                                                        fileInput.setAttribute('required', 'required');
                                                    } else {
                                                        fileInput.disabled = true;
                                                        fileInput.removeAttribute('required');
                                                    }
                                                }
                                            </script>
                                        </div>

                                        <?php if (($index + 1) % 3 == 0): ?>
                                            </div><div class="row">
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">ไม่มีรายการ</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center text-muted">
                            ไม่มีข้อมูลมาตรฐาน
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <?= $form->field($model, 'user_box')->widget(\toxor88\switchery\Switchery::className(), ['options' => ['label' => '', 'class' => 'form-control', 'onchange' => 'checkUserBox($(this))']])->label() ?>
        </div>
        <div class="col-lg-3">
            <label for=""><?= $model->attributeLabels()['marget_emp_id'] ?></label>
            <input type="text" class="form-control"
                   value="<?= $model->isNewRecord ? \backend\models\Employee::findNameFromUserId(\Yii::$app->user->id) : \backend\models\Employee::findNameFromUserId($model->marget_emp_id) ?>"
                   disabled="disabled">
        </div>
        <div class="col-lg-3">
            <?php $model->market_emp_date = $model->isNewRecord ? date('d/m/Y') : date('d/m/Y', strtotime($model->market_emp_date)); ?>
            <?= $form->field($model, 'market_emp_date')->widget(\kartik\date\DatePicker::className(), ['options' => ['readonly' => 'readonly']])->label() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($model, 'use_box_description')->textInput(['maxlength' => true, 'readonly' => 'readonly', 'class' => 'form-control use-box-description']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h4><b>เอกสารที่ต้องใช้</b></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php if ($attatch_doc_data != null): ?>
                <?php foreach ($attatch_doc_data as $valuex): ?>
                    <?php $loop_is_select = ''; ?>
                    <?php if ($model_attach_select != null): ?>
                        <?php foreach ($model_attach_select as $valuey) {
                            if ($valuey->customer_attatch_doc_id == $valuex->id) {
                                $loop_is_select = 'checked';
                            }
                        }
                        ?>
                        <input type="checkbox" name="attatch_doc[]" <?= $loop_is_select ?>
                               value="<?= $valuex->id ?>"> <?= $valuex->name ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-lg-3">
            <label for=""><?= $model->attributeLabels()['is_approve'] ?></label>
            <input type="text"
                   value="<?= $model->isNewRecord ? '' : ($model->is_approve ? 'อนุมัติ' : 'ยังไม่อนุมัติ') ?>"
                   class="form-control" readonly>
        </div>
        <div class="col-lg-3">
            <label for=""><?= $model->attributeLabels()['approve_emp_id'] ?></label>
            <input type="text" class="form-control"
                   value="<?= $model->isNewRecord ? '' : \backend\models\Employee::findNameFromUserId($model->approve_emp_id) ?>"
                   readonly>
        </div>
        <div class="col-lg-3">
            <label for=""><?= $model->attributeLabels()['approve_date'] ?></label>
            <input type="text" class="form-control"
                   value="<?= $model->isNewRecord ? '' : $model->approve_date != null ? date('d/m/Y', strtotime($model->approve_date)) : '' ?>"
                   readonly>
        </div>
        <div class="col-lg-3">

            <label for=""><?= $model->attributeLabels()['emp_operate_id'] ?></label>
            <input type="text" class="form-control"
                   value="<?= $model->isNewRecord ? '' : \backend\models\Employee::findNameFromUserId($model->emp_operate_id) ?>"
                   readonly>
        </div>
    </div>
    <?= $form->field($model, 'is_approve')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'marget_emp_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'approve_emp_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'approve_date')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'emp_operate_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'payment_method_id')->hiddenInput(['id' => 'payment-method-id'])->label(false) ?>
    <?= $form->field($model, 'customer_ref_id')->hiddenInput()->label(false) ?>
    <div class="form-group">
        <?php if ($model->isNewRecord || $model->is_approve == 0 || \backend\models\User::findName(\Yii::$app->user->id) == 'iceadmin' || \backend\models\User::findName(\Yii::$app->user->id) == 'mk' || \backend\models\User::findName(\Yii::$app->user->id) == 'adminm'): ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
        <?php ActiveForm::end(); ?>
        <?php if (!$model->isNewRecord) { ?>
            <?php if ($model->is_approve == 0 && \backend\models\User::findName(\Yii::$app->user->id) == 'iceadmin' || \backend\models\User::findName(\Yii::$app->user->id) == 'mk' || \backend\models\User::findName(\Yii::$app->user->id) == 'adminm') { ?>
                <div class="btn btn-info" onclick="recApprove();">อนุมัติ</div>
            <?php } ?>
            <?php if ($model->is_approve == 1) { ?>
                <!--                <div class="btn btn-warning" onclick="createNewCustomer();">สร้างรหัสลูกค้า</div>-->
            <?php } ?>
        <?php } ?>
        <?php if (!$model->isNewRecord): ?>
            <a class="btn btn-default" href="index.php?r=customerrequest/print&id=<?= $model->id ?>">พิมพ์</a>
        <?php endif; ?>
    </div>
</div>

<form id="form-convert" action="index.php?r=customerrequest/convertcustomer" method="post">
    <input type="hidden" class="current-request-id" name="request_id" value="<?= $model->id ?>">
</form>
<form action="index.php?r=customerrequest/approve" id="form-customer-approve" method="post">
    <input type="hidden" name="request_id" class="request-approve-id" value="<?= $model->id ?>">
</form>
<?php //echo 'approve is '.$model->is_approve;?>
<?php if ($model->is_approve == 100): ?>
    <hr/>
    <h5>แนบเอกสารสัญญา</h5>
    <form action="index.php?r=customerrequest/addcontractdoc" method="post" id="form-add-contract-doc" enctype="multipart/form-data">
        <input type="hidden" name="customer_req_id" value="<?=$model->id?>">
        <div class="row">
            <div class="col-lg-3">
                <input type="file" class="form-control" name="contract_doc">
            </div>
            <div class="col-lg-3">
                <button class="btn btn-primary">แนบเอกสารสัญญา</button>
            </div>
            <div class="col-lg-3"></div>
            <div class="col-lg-3"></div>
        </div>
    </form>
    <br>
    <?php
    $contract_data = getShopContract($model->customer_ref_id);
    ?>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="width: 5%;text-align: center;">#</th>
                    <th>ไฟล์</th>
                    <th style="width: 5%;">-</th>
                </tr>
                </thead>
                <tbody>
                <?php if($contract_data!=null):?>
                    <?php for($i=0;$i<=count($contract_data)-1;$i++):?>
                        <tr>
                            <td style="text-align: center;"><?=$i +1?></td>
                            <td>
                                <input type="hidden" class="remove-photo" value="<?=$contract_data[$i]['id']?>">
                                <a href="<?= \Yii::$app->getUrlManager()->getBaseUrl() . '/uploads/files/customers/' . $contract_data[$i]['doc'] ?>"
                                   target="_blank"><?= $contract_data[$i]['doc'] ?></a>
                            </td>
                            <td>
                                <div class="btn btn-sm btn-danger" data-var="<?=$contract_data[$i]['doc']?>" onclick="removecontactfile($(this))">ลบ</div>
                            </td>
                        </tr>
                    <?php endfor;?>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <h5>แนบรูปถังหน้าร้าน</h5>
    <form action="index.php?r=customerrequest/addshopphoto" method="post" id="form-add-contract-doc" enctype="multipart/form-data">
        <input type="hidden" name="customer_req_id" value="<?=$model->id?>">
        <div class="row">
            <div class="col-lg-3">
                <input type="file" class="form-control" name="shop_asset_file[]" multiple>
            </div>
            <div class="col-lg-3">
                <button class="btn btn-primary">แนบรูปภาพ</button>
            </div>
            <div class="col-lg-3"></div>
            <div class="col-lg-3"></div>
        </div>
    </form>

    <br>
    <?php
        $photo_data = getAssetShopPhoto($model->id);
    ?>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="width: 5%;text-align: center;">#</th>
                    <th>ไฟล์</th>
                    <th style="width: 5%;">-</th>
                </tr>
                </thead>
                <tbody>
                 <?php if($photo_data!=null):?>
                 <?php for($i=0;$i<=count($photo_data)-1;$i++):?>
                         <tr>
                             <td style="text-align: center;"><?=$i +1?></td>
                             <td>
                                 <input type="hidden" class="remove-photo" value="<?=$photo_data[$i]['id']?>">
                                 <a href="<?= \Yii::$app->getUrlManager()->getBaseUrl() . '/uploads/files/customers/' . $photo_data[$i]['photo'] ?>"
                                    target="_blank"><?= $photo_data[$i]['photo'] ?></a>
                             </td>
                             <td>
                                <div class="btn btn-sm btn-danger" data-var="<?=$photo_data[$i]['id']?>" onclick="removephoto($(this))">ลบ</div>
                             </td>
                         </tr>
                 <?php endfor;?>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>

    <form id="form-delete-photo" action="<?=\yii\helpers\Url::to(['customerrequest/deleteassetphoto'],true)?>" method="post">
        <input type="hidden" class="remove-photo-id" name="remove_id" value="">
        <input type="hidden" name="req_id" value="<?=$model->id;?>">
    </form>

    <form id="form-delete-contact-file" action="<?=\yii\helpers\Url::to(['customerrequest/deletecontactfile'],true)?>" method="post">
        <input type="hidden" class="remove-photo-id" name="remove_id" value="">
        <input type="hidden" name="req_id" value="<?=$model->id;?>">
        <input type="hidden" class="remove-file-name" name="remove_file_name" value="">
    </form>
<?php endif; ?>
<?php
function getRequestProductQty($req_id, $product_id)
{
    $qty = \common\models\CustomerRequestProduct::find()->where(['customer_req_id' => $req_id, 'product_id' => $product_id])->sum('qty');
    return $qty;
}

function getShopContract($id){
    $data = [];
    $contract_no = \backend\models\Customer::find()->where(['id'=>$id])->one();
    if($contract_no){
        array_push($data,['id'=>$contract_no->id,'doc'=>$contract_no->contact_file]);
    }
    return $data;
}

function getAssetShopPhoto($cus_req_id){
    $data = [];
    if($cus_req_id){
        $model = \common\models\CustomerRequestAssetPhoto::find()->where(['customer_req_id'=>$cus_req_id])->all();
        if($model){
            foreach ($model as $value){
                array_push($data,['id'=>$value->id,'photo'=>$value->photo]);
            }
        }
    }
    return $data;
}

?>

<?php
$url_to_getcity = \yii\helpers\Url::to(['customer/showcity'], true);
$url_to_getdistrict = \yii\helpers\Url::to(['customer/showdistrict'], true);
$url_to_getzipcode = \yii\helpers\Url::to(['customer/showzipcode'], true);
$url_to_getAddress = \yii\helpers\Url::to(['customer/showaddress'], true);
$url_to_deletephoto = \yii\helpers\Url::to(['customerrequest/delete-photo'],true);
$csrf = \Yii::$app->request->csrfToken;
$js = <<< JS
$(document).ready(function() {
    // จัดการเมื่อ checkbox ถูกคลิก
    $('.standard-item-checkbox').on('change', function() {
        var standardId = $(this).data('standard-id');
        var itemId = $(this).data('item-id');
        var isChecked = $(this).is(':checked');
        
        // สามารถเพิ่ม logic เพิ่มเติมได้ที่นี่
        console.log('Standard ID:', standardId, 'Item ID:', itemId, 'Checked:', isChecked);
    });
    
      // ลบรูปภาพ
    $(document).on('click', '.delete-photo', function() {
        var photoId = $(this).data('photo-id');
        var photoItem = $(this).closest('.photo-item');
        
        if (confirm('คุณแน่ใจหรือไม่ที่จะลบรูปภาพนี้?')) {
            $.ajax({
                url: '$url_to_deletephoto',
                method: 'POST',
                data: {
                    photo_id: photoId,
                    _csrf: "$csrf",
                },
                success: function(response) {
                    if (response.success) {
                        photoItem.fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        alert('เกิดข้อผิดพลาดในการลบรูปภาพ');
                    }
                },
                error: function() {
                    alert('เกิดข้อผิดพลาดในการเชื่อมต่อ');
                }
            });
        }
    });

    // Preview รูปภาพก่อนอัพโหลด
    $(document).on('change', 'input[type="file"]', function() {
        var files = this.files;
        var previewContainer = $(this).siblings('.photo-preview');
        
        if (previewContainer.length === 0) {
            previewContainer = $('<div class="photo-preview" style="margin-top: 5px;"></div>');
            $(this).after(previewContainer);
        }
        
        previewContainer.empty();
        
        if (files.length > 0) {
            previewContainer.append('<small class="text-muted">ตัวอย่างรูปภาพที่จะอัพโหลด:</small><br>');
            
            for (var i = 0; i < Math.min(files.length, 5); i++) { // แสดงแค่ 5 รูปแรก
                if (files[i].type.match('image.*')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.append(
                            '<img src="' + e.target.result + '" style="max-width: 50px; max-height: 50px; margin: 2px; border: 1px solid #ddd; border-radius: 3px;">'
                        );
                    };
                    reader.readAsDataURL(files[i]);
                }
            }
            
            if (files.length > 5) {
                previewContainer.append('<small class="text-muted">และอีก ' + (files.length - 5) + ' รูป...</small>');
            }
        }
    });

    // เคลียร์ preview เมื่อ reset form
    $('form').on('reset', function() {
        $('.photo-preview').empty();
    });
});
function createNewCustomer(){
    var request_id = $(".current-request-id").val();
    if(request_id > 0){
        if(confirm('คุณมันใจที่จะสร้างรหัสลูกค้าใหม่ใช่หรือไม่ ?')){
            $("form#form-convert").submit();
        }
    }
}
function getCity(e){
    $.post("$url_to_getcity"+"&id="+e.val(),function(data){
        $("#selected-city").html(data);
        $("#selected-city").prop("disabled","");
    });
}

function getDistrict(e){
    $.post("$url_to_getdistrict"+"&id="+e.val(),function(data){
                                          $("#selected-district").html(data);
                                          $("selected-district").prop("disabled","");

                                        });
//                                           $.post("$url_to_getzipcode"+"&id="+e.val(),function(data){
//                                                $("#zipcode").val(data);
//                                              });
}
function getPaymentType(checkbox) {
   // alert(checkbox.val());
  const checkboxes = document.querySelectorAll('.payment-checkbox');
  //alert(checkboxes.length);
  checkboxes.forEach((box) => {
//  console.log(box.value);
   if(box.value != checkbox.val()){
     box.checked = false;
   }
  });
  $("#payment-method-id").val(checkbox.val());
}

function recApprove(){
    //e.preventDefault();
    var request_id = $(".request-approve-id").val();
    if(request_id =='' || request_id == 0 || typeof(request_id) === "undefined"){
        return;
    }
    swal({
        title: "ต้องการอนุมัติรายการนี้ใช่หรือไม่",
        text: "",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true
    }, function () {
        $("form#form-customer-approve").submit();
    });
}

function removephoto(e){
    var id = e.attr("data-var");
    if(id){
        swal({
        title: "ต้องการลบรายการนี้ใช่หรือไม่",
        text: "",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true
    }, function () {
        $(".remove-photo-id").val(id);
        $("form#form-delete-photo").submit();
    });
    }
    
}
function removecontactfile(e){
    var id = e.attr("data-var");
    if(id != ''){
        swal({
        title: "ต้องการลบรายการนี้ใช่หรือไม่",
        text: "",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true
    }, function () {
        $(".remove-photo-id").val(id);
        $(".remove-file-name").val(id);
        $("form#form-delete-contact-file").submit();
    });
    }
    
}
function checkUserBox(e){
   if(e.is(":checked")){
      // alert('chekced');
       $(".use-box-description").attr("readonly",false);
       $(".use-box-description").attr("required",true);
   }else{
      // alert('unchecked');
       $(".use-box-description").attr("readonly",true);
       $(".use-box-description").attr("required",false);
   }
}


JS;
$this->registerJs($js, static::POS_END);
?>
