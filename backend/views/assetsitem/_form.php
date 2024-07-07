<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Assetsitem */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="assetsitem-form">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <input type="hidden" class="remove-photo-list" value="">
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <?= $form->field($model, 'asset_no')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-1"></div>
        </div>

        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <?= $form->field($model, 'asset_name')->textInput(['maxlength' => true]) ?>
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
            <div class="col-lg-10">
                <?= $form->field($model, 'rent_price')->textinput(['maxlength' => true]) ?>
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

        <br/>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <label for="">เลือกไฟล์</label>
                <input type="file" name="asset_photo[]" multiple>
            </div>
            <div class="col-lg-1"></div>
        </div>

        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 30%">ชิ่อไฟล์</th>
                        <th style="width: 30%">รูปภาพ</th>
                        <th>-</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($modelphoto != null): ?>
                        <?php $i = 0; ?>
                        <?php foreach ($modelphoto as $value): ?>
                            <?php $i += 1; ?>
                            <tr>
                                <td><?= $i ?> </td>
                                <td>
                                    <a href="<?= \Yii::$app->urlManagerFrontend->getBaseUrl() . '/uploads/assetphoto/' . $value->photo ?>"
                                       target="_blank"><?= $value->photo ?></a></td>
                                <td>
                                    <img src="<?= \Yii::$app->urlManagerFrontend->getBaseUrl() . '/uploads/assetphoto/' . $value->photo ?>"
                                         alt="" style="width: 25%">
                                </td>
                                <td>
                                    <input type="hidden" class="line-id" value="<?= $value->id ?>">
                                    <div class="btn btn-danger" onclick="removephoto($(this))">ลบ</div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-1"></div>
        </div>

        <br>

<!--        echo Yii::$app->urlManagerFrontend->createAbsoluteUrl(['site/index','id'=>4]);-->
<!--        echo Yii::$app->urlManagerFrontend->createUrl(['site/index','id'=>4]);-->
<!--        echo Yii::$app->urlManagerFrontend->getBaseUrl();-->
<!--        echo Yii::$app->urlManagerFrontend->getHostInfo();-->
<!--        echo Yii::$app->urlManagerFrontend->getScriptUrl();-->

        <?php ActiveForm::end(); ?>

    </div>

<?php
$js = <<<JS
var removephotolist = [];
function removephoto(e){
    var line_id = e.closest("tr").find(".line-id").val();
    if(line_id>0){
        removephotolist.push(line_id);
        $(".remove-photo-list").val(removephotolist);
        // console.log(removeformlist);
        e.parent().parent().remove();
    }
} 
JS;

$this->registerJs($js, static::POS_END);
?>