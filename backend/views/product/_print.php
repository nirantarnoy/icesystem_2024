<?php

?>
<div class="report-view">
    <div class="row">
        <div class="col-xs-12">
            <div class="report-f24">
                <label for="">รายการรหัสสินค้า</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-report">
                <thead>
                <tr>
                    <th class="report-f18" style="text-align: center" width="10%">รหัสสินค้า</th>
                    <th class="report-f18" style="text-align: center">ชื่อ</th>
                    <th class="report-f18" style="text-align: center">ประเภท</th>
                    <th class="report-f18" style="text-align: center">กลุ่ม</th>
                    <th class="report-f18" style="text-align: center">สถานะ</th>
                </tr>
                </thead>
                <tbody>
                   <?php foreach ($model as $value):?>
                   <?php
                       $cat = \backend\models\Productgroup::findName($value->product_group_id);
                       $type = \backend\models\Producttype::findName($value->product_type_id);
                       $status = \backend\helpers\ProductStatus::getTypeById($value->status);
                       ?>
                       <tr>
                           <td class="report-f18" style="text-align: center"><?=$value->code?></td>
                           <td class="report-f18" style="text-align: center"><?=$value->name?></td>
                           <td class="report-f18" style="text-align: center"><?=$type?></td>
                           <td class="report-f18" style="text-align: center"><?=$cat?></td>
                           <td class="report-f18" style="text-align: center"><?=$status?></td>
                       </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
