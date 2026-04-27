<?php

use yii\helpers\Url;

?>
<div class="row">
    <div class="col-lg-12">
        <?php if (\Yii::$app->session->getFlash('success') !== null): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= \Yii::$app->session->getFlash('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>
</div>

<form action="<?= Url::to(['customerroutenumupdate/index']) ?>" method="post">
    <div class="row">
        <div class="col-lg-3">
            <?php
            echo \kartik\select2\Select2::widget([
                'name' => 'route_id',
                'value' => $route_id,
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['status' => 1, 'branch_id' => 2])->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => 'เลือกสายส่ง',
                ],
                'pluginOptions' => [
                    'allowClear' => true,

                ],]);
            ?>
        </div>
        <div class="col-lg-3">
            <button class="btn btn-primary">ค้นหา</button>
        </div>
    </div>
</form>
<br/>
<form action="<?= Url::to(['customerroutenumupdate/update'],true) ?>" method="post">
    <div class="row">
        <div class="col-lg-12">
            <table class="table">
                <thead>
                <tr>
                    <th>รหัสลูกค้า</th>
                    <th>ชื่อลูกค้า</th>
                    <th>RouteNum</th>
                    <th>แก้เป็น</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($model != null): ?>
                    <?php foreach ($model as $value) { ?>
                        <tr>
                            <td>
                                <input type="hidden" name="customer_id[]" value="<?= $value->id ?>">
                                <?= $value->code ?>
                            </td>
                            <td><?= $value->name ?></td>
                            <td><?= $value->route_num ?></td>
                            <td>
                                <input type="text" class="form-control" name="route_num[]" value="">
                            </td>
                        </tr>
                    <?php } ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <button class="btn btn-primary">อัปเดต</button>
        </div>
    </div>
</form>
