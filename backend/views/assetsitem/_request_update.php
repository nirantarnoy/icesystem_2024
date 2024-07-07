<?php
?>
<div class="row">
    <div class="col-lg-12">
        <h3>รายละเอียด</h3>
    </div>
</div>
<form action="<?=\yii\helpers\Url::to(['assetsitem/assetrequestsave'],true)?>" id="form-update" method="post">
    <input type="hidden" name="request_id" value="<?=$model->id?>">
    <input type="hidden" name="asset_no" value="<?= \backend\models\Assetsitem::findCode($model->asset_id) ?>">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-striped">
                <tr>
                    <td style="width: 20%;font-weight: bold;">ลูกค้า</td>
                    <td> <?= \backend\models\Customer::findName($model->customer_id) ?></td>
                </tr>
                <tr>
                    <td style="width: 20%;font-weight: bold;">รหัส</td>
                    <td> <?= \backend\models\Assetsitem::findCode($model->asset_id) ?></td>
                </tr>
                <tr>
                    <td style="width: 20%;font-weight: bold;">ตั้งรหัสใหม่</td>
                    <td>
                        <input type="text" class="form-control" name="new_asset_no" value="<?= \backend\models\Assetsitem::findCode($model->asset_id) ?>">
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%;font-weight: bold;">จำนวน</td>
                    <td>
                        <input type="text" class="form-control" name="new_asset_qty" value="1">
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</form>
<br/>
<div class="row">
    <div class="col-lg-12">
        <h3>รูปภาพ</h3>
    </div>
</div>
<br/>
<div class="row">
    <?php foreach ($model_photo as $value): ?>
        <div class="col-lg-3">
            <img src="<?= \Yii::$app->urlManagerFrontend->getBaseUrl() ?>/uploads/assetphoto/<?= $value->photo ?>"
                 alt="" width="100%">
        </div>
    <?php endforeach; ?>
</div>