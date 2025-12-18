<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use kartik\daterange\DateRangePicker;

$company_id = 1;
$branch_id = 1;
if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id = \Yii::$app->user->identity->branch_id;
}

$this->title = 'รายงานสรุปการขายตามสายส่ง';

$model_line = $dataProvider->getModels();

?>
<div id="div1">
    <form action="index.php" method="get">
    <input type="hidden" name="r" value="pos/sales-by-route">
        <div class="row">
            <div class="col-lg-3">
                <div class="label">เลือกช่วงวันที่</div>
                <?php
                echo \kartik\date\DatePicker::widget([
                    'name' => 'from_date',
                    'value' => $from_date,
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'todayHighlight' => true,
                        'autoclose' => true,
                    ]
                ]);
                ?>
            </div>
            <div class="col-lg-3">
                <div class="label">ถึงวันที่</div>
                <?php
                echo \kartik\date\DatePicker::widget([
                    'name' => 'to_date',
                    'value' => $to_date,
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'todayHighlight' => true,
                        'autoclose' => true,
                    ]
                ]);
                ?>
            </div>
            <div class="col-lg-3">
                <div class="label">สายส่ง</div>
                <?php
                echo \kartik\select2\Select2::widget([
                    'name' => 'route_id',
                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1])->all(), 'id', 'name'),
                    'value' => $route_id,
                    'options' => [
                        'placeholder' => 'เลือกสายส่ง',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]);
                ?>
            </div>
            <div class="col-lg-2">
                <div class="label" style="color: white">ค้นหา</div>
                <button type="submit" class="btn btn-primary">ค้นหา</button>
            </div>
        </div>
    </form>
    <br/>

    <div class="row">
        <div class="col-lg-12">
            <table class="table" style="width: 100%" id="table-data">
                <thead>
                <tr>
                    <td rowspan="2" style="text-align: center;border: 1px solid grey;vertical-align: middle"><b>รหัส</b></td>
                    <td rowspan="2" style="text-align: center;border: 1px solid grey;vertical-align: middle"><b>รายการสินค้า</b></td>
                    <td rowspan="2" style="text-align: center;border: 1px solid grey;vertical-align: middle"><b>ราคาขาย</b></td>
                    <td colspan="3" style="text-align: center;border: 1px solid grey"><b>จำนวนขาย</b></td>
                    <td colspan="3" style="text-align: center;border: 1px solid grey"><b>รวมเงิน</b></td>
                </tr>
                <tr>
                    <td style="text-align: center;border: 1px solid grey"><b>สด</b></td>
                    <td style="text-align: center;border: 1px solid grey"><b>เชื่อ</b></td>
                    <td style="text-align: center;border: 1px solid grey; background-color: #e8f8f5"><b>รวม</b></td>
                    <td style="text-align: center;border: 1px solid grey"><b>สด</b></td>
                    <td style="text-align: center;border: 1px solid grey"><b>เชื่อ</b></td>
                    <td style="text-align: center;border: 1px solid grey; background-color: #d4efdf"><b>รวม</b></td>
                </tr>
                </thead>
                <tbody>
                <?php
                $total_all_cash = 0;
                $total_all_credit = 0;
                $total_all_qty_sum = 0;
                $last_product = '';
                ?>
                <?php foreach ($model_line as $value): ?>
                    <?php
                    $is_group = 0;
                    $line_qty_sum = $value->qty;
                    $line_amount_sum = $value->line_total_cash + $value->line_total_credit;

                    $total_all_qty_sum += $line_qty_sum;
                    $total_all_cash += $value->line_total_cash;
                    $total_all_credit += $value->line_total_credit;

                    if ($last_product == $value->code) {
                        $is_group = 1;
                    } else {
                        $is_group = 0;
                    }
                    $last_product = $value->code;
                    ?>
                    <tr>
                        <td style="text-align: center;border: 1px solid grey;"><?= $is_group == 1 ? '' : $value->code ?></td>
                        <td style="text-align: left;border: 1px solid grey"><?= $is_group == 1 ? '' : $value->name ?></td>
                        <td style="text-align: right;border: 1px solid grey"><?= number_format($value->price, 2) ?></td>
                        <td style="text-align: right;border: 1px solid grey"><?= number_format($value->line_qty_cash, 2) ?></td>
                        <td style="text-align: right;border: 1px solid grey"><?= number_format($value->line_qty_credit + $value->line_qty_free, 2) ?></td>
                        <td style="text-align: right;border: 1px solid grey; background-color: #e8f8f5"><?= number_format($line_qty_sum, 2) ?></td>
                        <td style="text-align: right;border: 1px solid grey"><?= number_format($value->line_total_cash, 2) ?></td>
                        <td style="text-align: right;border: 1px solid grey"><?= number_format($value->line_total_credit, 2) ?></td>
                        <td style="text-align: right;border: 1px solid grey; background-color: #d4efdf"><?= number_format($line_amount_sum, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr style="background-color: #1abc9c">
                    <td colspan="3" style="text-align: right;border: 1px solid grey;text-align: center"><b>รวม</b></td>
                    <td style="text-align: right;border: 1px solid grey;text-align: right"><b></b></td>
                    <td style="text-align: right;border: 1px solid grey;text-align: right"><b></b></td>
                    <td style="text-align: right;border: 1px solid grey;text-align: right; background-color: #e8f8f5"><b><?= number_format($total_all_qty_sum, 2) ?></b></td>
                    <td style="text-align: right;border: 1px solid grey;text-align: right"><b><?= number_format($total_all_cash, 2) ?></b></td>
                    <td style="text-align: right;border: 1px solid grey;text-align: right"><b><?= number_format($total_all_credit, 2) ?></b></td>
                    <td style="text-align: right;border: 1px solid grey;text-align: right; background-color: #d4efdf"><b><?= number_format($total_all_cash + $total_all_credit, 2) ?></b></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
