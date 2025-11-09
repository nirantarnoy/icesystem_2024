<?php
date_default_timezone_set('Asia/Bangkok');

use chillerlan\QRCode\QRCode;
use common\models\LoginLog;
use kartik\daterange\DateRangePicker;
use yii\web\Response;

//require_once __DIR__ . '/vendor/autoload.php';
//require_once 'vendor/autoload.php';
// เพิ่ม Font ให้กับ mPDF



$user_id = \Yii::$app->user->id;
$find_sale_type = 0;
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp',
//$mpdf = new \Mpdf\Mpdf([
    //'tempDir' => '/tmp',
    'mode' => 'utf-8',
    // 'mode' => 'utf-8', 'format' => [80, 120],
    'fontdata' => $fontData + [
            'sarabun' => [ // ส่วนที่ต้องเป็น lower case ครับ
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNewItalic.ttf',
                'B' => 'THSarabunNewBold.ttf',
                'BI' => "THSarabunNewBoldItalic.ttf",
            ]
        ],
]);

//$mpdf->SetMargins(-10, 1, 1);
//$mpdf->SetDisplayMode('fullpage');
$mpdf->AddPageByArray([
    'margin-left' => 5,
    'margin-right' => 0,
    'margin-top' => 0,
    'margin-bottom' => 1,
]);

//$customer_name = $trans_data[0]['customer_id']?getCustomername($connect, $trans_data[0]['customer_id']):$trans_data[0]['customer_name'];
//$model_product_daily = \common\models\QueryProductTransDaily::find()->where(['date(trans_date)' => date('Y-m-d')])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])->all();
//$model_product_daily = \common\models\StockTrans::find()->select("product_id")->where(['BETWEEN', 'trans_date', date('Y-m-d H:i:s', strtotime($from_date)), date('Y-m-d H:i:s', strtotime($to_date))])->andFilterWhere(['activity_type_id' => 5, 'company_id' => $company_id, 'branch_id' => $branch_id])->groupBy('product_id')->orderBy(['product_id' => SORT_ASC])->all();
$model_product_daily = \backend\models\Product::find()->where(['status' => 1, 'company_id' => $company_id, 'branch_id' => $branch_id])->orderBy(['item_pos_seq' => SORT_ASC])->all();
//$user_login_datetime = '';
//$model_c_login = LoginLog::find()->select('MIN(login_date) as login_date')->where(['user_id' => $user_id, 'status' => 1])->one();
//if ($model_c_login != null) {
//    $user_login_datetime = date('Y-m-d H:i:s', strtotime($model_c_login->login_date));
//} else {
//    $user_login_datetime = date('Y-m-d H:i:s');
//}
?>
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
    <link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
    <style>
        /*body {*/
        /*    font-family: sarabun;*/
        /*    !*font-family: garuda;*!*/
        /*    font-size: 18px;*/
        /*}*/

        #div1 {
            font-family: sarabun;
            /*font-family: garuda;*/
            font-size: 16px;
        }

        table.table-header {
            border: 0px;
            border-spacing: 1px;
        }

        table.table-footer {
            border: 0px;
            border-spacing: 0px;
        }

        table.table-header td, th {
            border: 0px solid #dddddd;
            text-align: left;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        table.table-title {
            border: 1px solid grey;
            border-spacing: 0px;
        }

        table.table-title td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            /*background-color: #dddddd;*/
        }

        table.table-detail {
            border-collapse: collapse;
            width: 100%;
        }

        table.table-detail td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 2px;
        }

    </style>
    <!--    <script src="vendor/jquery/jquery.min.js"></script>-->
    <!--    <script type="text/javascript" src="js/ThaiBath-master/thaibath.js"></script>-->
</head>

<div>
    <form action="<?= \yii\helpers\Url::to(['adminreport/printallsummary'], true) ?>" method="post" id="form-search">
        <input type="hidden" class="btn-order-type" name="btn_order_type" value="<?= $btn_order_type ?>">
        <table class="table-header" style="width: 100%;font-size: 18px;" border="0">
            <tr>

                <td style="width: 20%">
                    <?php
                    echo DateRangePicker::widget([
                        'name' => 'from_date',
                        // 'value'=>'2015-10-19 12:00 AM',
                        'value' => $from_date != null ? date('Y-m-d H:i', strtotime($from_date)) : date('Y-m-d H:i'),
                        //    'useWithAddon'=>true,
                        'convertFormat' => true,
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'ถึงวันที่',
                            //  'onchange' => 'this.form.submit();',
                            'autocomplete' => 'off',
                        ],
                        'pluginOptions' => [
                            'timePicker' => true,
                            'timePickerIncrement' => 1,
                            'locale' => ['format' => 'Y-m-d H:i'],
                            'singleDatePicker' => true,
                            'showDropdowns' => true,
                            'timePicker24Hour' => true
                        ]
                    ]);
                    ?>
                </td>
                <td>
                    <input type="submit" class="btn btn-primary" value="ค้นหา">
                </td>
                <td style="width: 25%"></td>
            </tr>
        </table>
    </form>
    <br/>
    <div id="div1">
        <table class="table-header" width="100%">
            <tr>
                <td style="text-align: center; font-size: 20px; font-weight: bold">รายงานสรุปจำนวนขายประจำเดือน</td>
            </tr>
        </table>
        <br>
        <table class="table-header" width="100%">
            <tr>
                <td style="text-align: center; font-size: 20px; font-weight: normal">
                    เดือน <span
                            style="color: red"><?= date('m', strtotime($from_date)) . '/' . date('Y', strtotime($from_date)) ?></span>
                </td>
            </tr>
        </table>
        <br>

        <?php
          $model_transfer_branch = \backend\models\Stocktrans::find()->select(['transfer_branch_id'])->where(['year(trans_date)'=>date('Y',strtotime($from_date))])->andFilterWhere(['is not','transfer_branch_id',new yii\db\Expression('NULL')])->groupBy(['transfer_branch_id'])->all();
        ?>
        <form action="<?=\yii\helpers\Url::to(['adminreport/saveeditqty'],true)?>" method="post">
            <input type="hidden" class="line-trans-date" name="line_trans_date" value="<?= date('Y-m-d',strtotime($from_date)) ?>">
            <table class="table-header" width="100%">
            </table>
            <table class="table-title" id="table-data" style="width: 100%">
                <thead>
                <tr>
                    <th style="text-align: center;">สินค้า</th>
                    <th style="text-align: center;">สาขาอื่น</th>
                    <?php foreach ($model_transfer_branch as $value):?>
                        <th style="text-align: center;"><?= \backend\models\Transferbrach::findName($value->transfer_branch_id) ?></th>
                    <?php endforeach;?>
                    <th style="text-align: center;">ผลิต</th>
                    <th style="text-align: center;">แปรสภาพ</th>
                    <th style="text-align: center;">รับคืน</th>
                    <th style="text-align: center;">สด</th>
                    <th style="text-align: center;">เชื่อ</th>
                    <th style="text-align: center;">เชื่อรถ</th>
                    <th style="text-align: center;background-color: #9B7536">ผลต่าง</th>
                    <th style="text-align: center;background-color: yellow">ขายรถ</th>
                    <th style="text-align: center;">ขายรถ</th>
                    <th style="text-align: center;">ฟรี</th>
                    <th style="text-align: center;">เชื่อต่างสาขา</th>
                    <th style="text-align: center;">เบิกเติม</th>
                    <th style="text-align: center;">เสีย</th>
                    <th style="text-align: center;">ยกมา</th>
                    <th style="text-align: center;">ยกไป</th>
                </tr>
                </thead>

                <?php
                $line_total_prodrec_qty = 0;
                $line_total_reprocess_qty = 0;
                $line_total_transfer_in_qty = 0;
                $line_total_return_qty = 0;
                $line_total_cash_qty = 0;
                $line_total_credit_qty = 0;
                $line_total_credit_car_qty = 0;
                $line_total_issue_transfer_qty = 0;
                $line_total_free_qty = 0;
                $line_total_scrap_qty = 0;
                $line_total_refill_qty = 0;

                $line_sale_car_qty = 0;
                $line_balance_in_qty = 0;
                $line_balance_out_qty = 0;
                ?>
                <?php foreach ($model_product_daily as $value): ?>
                    <?php
                    $line_total_prodrec_qty = getProdrecQty($from_date, $value->id);
                    $line_total_reprocess_qty = getReprocessQty($from_date, $value->id);
                    $line_total_transfer_in_qty = getTransferInQty($from_date, $value->id);
                    $line_total_return_qty = getReturnQty($from_date, $value->id);
                    $line_total_cash_qty = getCashQty($from_date, $value->id);
                    $line_total_credit_qty = getCreditQty($from_date, $value->id);
                    $line_total_credit_car_qty = getIssueCarQty($from_date, $value->id);
                    $line_total_issue_transfer_qty = getIssueTransferQty($from_date, $value->id);
                    $line_total_free_qty = getFreeQty($from_date, $value->id);
                    $line_total_scrap_qty = getScrapQty($from_date, $value->id);
                    $line_total_refill_qty = getIssueRefillQty($from_date, $value->id);
                    $line_total_balance_in_qty = getBalanceInQty($from_date, $value->id);
                    $line_total_balance_out_qty = getBalanceOutQty($from_date, $value->id);

                    $line_sale_car_qty = getSaleCarQty($from_date, $value->id);
                    $line_sale_car_qty2 = 0;
                    $line_sale_car_qty_color = "";
                    if($line_sale_car_qty !=null){
                        $line_sale_car_qty2 = $line_sale_car_qty[0]['qty'];
                        if($line_sale_car_qty[0]['is_edit'] == 1){
                            $line_sale_car_qty_color = "color: red";
                        }
                    }

                    $line_sale_car_deduct_free_qty = $line_sale_car_qty2 - $line_total_free_qty;
                    ?>
                    <tr>
                        <td style="text-align: center;"><?= $value->code ?></td>
                        <td style="text-align: center;"><?= number_format($line_total_transfer_in_qty, 0) ?></td>
                        <?php foreach ($model_transfer_branch as $valuex):?>
                        <?php $transfer_branch_qty = getTransferBranchQty($from_date, $value->id, $valuex->transfer_branch_id);?>
                            <th style="text-align: center;"><?= number_format($transfer_branch_qty,0) ?></th>
                        <?php endforeach;?>
                        <td style="text-align: center;"><?= number_format($line_total_prodrec_qty, 0) ?></td>
                        <td style="text-align: center;"><?= number_format($line_total_reprocess_qty, 0) ?></td>
                        <td style="text-align: center;"><?= number_format($line_total_return_qty, 0) ?></td>
                        <td style="text-align: center;"><?= number_format($line_total_cash_qty, 0) ?></td>
                        <td style="text-align: center;"><?= number_format($line_total_credit_qty, 0) ?></td>
                        <td style="text-align: center;"><?= number_format($line_total_credit_car_qty, 0) ?></td>
                        <td style="text-align: center;background-color: #9B7536"><?= number_format($line_total_credit_car_qty - $line_sale_car_qty2, 0) ?></td>
                        <td style="text-align: center;background-color: yellow">
                            <input type="hidden" class="line-product-id" name="line_product_id[]" value="<?= $value->id ?>">
                            <input type="text" style="<?=$line_sale_car_qty_color?>" class="form-control line-new-qty" name="new_qty[]"
                                   value=" <?= number_format($line_sale_car_qty2, 0) ?>" onchange="editLineQty($(this));">
                        </td>
                        <td style="text-align: center;"><?= number_format($line_sale_car_deduct_free_qty, 0) ?></td>
                        <td style="text-align: center;"><?= number_format($line_total_free_qty, 0) ?></td>
                        <td style="text-align: center;"><?= number_format($line_total_issue_transfer_qty, 0) ?></td>
                        <td style="text-align: center;"><?= number_format($line_total_refill_qty, 0) ?></td>
                        <td style="text-align: center;"><?= number_format($line_total_scrap_qty, 0) ?></td>
                        <td style="text-align: center;"><?= number_format($line_total_balance_in_qty, 0) ?></td>
                        <td style="text-align: center;"><?= number_format($line_total_balance_out_qty, 0) ?></td>
                    </tr>
                <?php endforeach; ?>

                <tfoot>

                </tfoot>
            </table>
            <br />

        </form>
    </div>
    <br/>
    <table width="100%" class="table-title" style="border: none;">
        <td style="text-align: right">
            <button id="btn-export-excel" class="btn btn-secondary">Export Excel</button>
            <button id="btn-print" class="btn btn-warning" onclick="printContent('div1')">Print</button>
        </td>
    </table>

    <br/>
    <!--<script src="../web/plugins/jquery/jquery.min.js"></script>-->
    <!--<script>-->
    <!--    $(function(){-->
    <!--       alert('');-->
    <!--    });-->
    <!--   window.print();-->
    <!--</script>-->
    <?php
    //echo '<script src="../web/plugins/jquery/jquery.min.js"></script>';
    //echo '<script type="text/javascript">alert();</script>';
    ?>
</div>
</body>
</html>
<?php
function getTransferbranchQty($t_date, $product_id, $branch_id)
{
    $qty = 0;
    if($product_id != null){
        $qty = \backend\models\Stocktrans::find()->where(['year(trans_date)'=>date('Y', strtotime($t_date)), 'month(trans_date)'=>date('m', strtotime($t_date)), 'product_id'=>$product_id, 'transfer_branch_id'=>$branch_id])->sum('qty');
    }
    return $qty;
}

function getProdrecQty($t_date, $product_id)
{
    $total_qty = 0;
    $total_qty2 = 0;

    $model_shift = \common\models\TransactionPosSaleSum::find()->where(['product_id' => $product_id, 'month(trans_date)' => date('m', strtotime($t_date)), 'year(trans_date)' => date('Y', strtotime($t_date))])->groupBy('shift')->all();
    if ($model_shift) {
        foreach ($model_shift as $value) {
            $model_adust_qty = \common\models\CloseDailyAdjust::find()->where(['product_id' => $product_id, 'shift' => $value->shift])->andFilterWhere(['is not', 'prodrec_qty', new \yii\db\Expression('null')])->sum('prodrec_qty');
            if ($model_adust_qty != null) {
                if ($model_adust_qty >= 0 || $model_adust_qty != null) {
                    $total_qty += $model_adust_qty;
                }
                // $total_qty+=$model_adust_qty;
            } else {
                if ($value->prodrec_qty >= 0) {
                    $total_qty += $value->prodrec_qty;
                }
            }
            //$total_qty = $total_qty +1;
        }

    }
    return $total_qty;
}

function getReprocessQty($t_date, $product_id)
{
    $total_qty = 0;
    $total_qty2 = 0;

    $model_shift = \common\models\TransactionPosSaleSum::find()->where(['product_id' => $product_id, 'month(trans_date)' => date('m', strtotime($t_date)), 'year(trans_date)' => date('Y', strtotime($t_date))])->groupBy('shift')->all();
    if ($model_shift) {
        foreach ($model_shift as $value) {
            $model_adust_qty = \common\models\CloseDailyAdjust::find()->where(['product_id' => $product_id, 'shift' => $value->shift])->andFilterWhere(['is not', 'reprocess_qty', new \yii\db\Expression('null')])->all();
            if ($model_adust_qty) {
                foreach($model_adust_qty as $valuex){
                    $total_qty += ($valuex->reprocess_qty);
                }
                // $total_qty+=$model_adust_qty;
            } else {
                $total_qty += $value->reprocess_qty;
            }
            //$total_qty = $total_qty +1;
        }

    }
    return $total_qty;
}

function getTransferInQty($t_date, $product_id)
{
    $total_qty = 0;
    $total_qty2 = 0;

    $model_shift = \common\models\TransactionPosSaleSum::find()->where(['product_id' => $product_id, 'month(trans_date)' => date('m', strtotime($t_date)), 'year(trans_date)' => date('Y', strtotime($t_date))])->groupBy('shift')->all();
    if ($model_shift) {
        foreach ($model_shift as $value) {
            $model_adust_qty = \common\models\CloseDailyAdjust::find()->where(['product_id' => $product_id, 'shift' => $value->shift])->andFilterWhere(['is not', 'transfer_qty', new \yii\db\Expression('null')])->all();
        //    $model_adust_qty = \common\models\CloseDailyAdjust::find()->where(['product_id' => $product_id, 'date(shift_date)'=>date('Y-m-d', strtotime($t_date))])->andFilterWhere(['is not', 'transfer_qty', new \yii\db\Expression('null')])->sum('transfer_qty');
            if ($model_adust_qty !=null) {
                foreach($model_adust_qty as $valuex){
                    $total_qty += ($valuex->transfer_qty);
                }

            } else {
                $total_qty += ($value->transfer_in_qty);
               // $total_qty = 2;
            }
            //$total_qty = $total_qty +1;
        }

    }
    return $total_qty;
}

function getReturnQty($t_date, $product_id)
{
    $total_qty = 0;
    $total_qty2 = 0;

    $model_shift = \common\models\TransactionPosSaleSum::find()->where(['product_id' => $product_id, 'month(trans_date)' => date('m', strtotime($t_date)), 'year(trans_date)' => date('Y', strtotime($t_date))])->groupBy('shift')->all();
    if ($model_shift) {
        foreach ($model_shift as $value) {
            $model_adust_qty = \common\models\CloseDailyAdjust::find()->where(['product_id' => $product_id, 'shift' => $value->shift])->andFilterWhere(['is not', 'return_qty', new \yii\db\Expression('null')])->all();
            if ($model_adust_qty !=null) {
                foreach($model_adust_qty as $valuex){
                    $total_qty += ($valuex->return_qty);
                }
                // $total_qty+=$model_adust_qty;
            } else {
                $total_qty += $value->return_qty;
            }
            //$total_qty = $total_qty +1;
        }

    }
    return $total_qty;
}

function getCashQty($t_date, $product_id)
{
    $total_qty = 0;
    $total_qty2 = 0;

    $model_shift = \common\models\TransactionPosSaleSum::find()->where(['product_id' => $product_id, 'month(trans_date)' => date('m', strtotime($t_date)), 'year(trans_date)' => date('Y', strtotime($t_date))])->groupBy('shift')->all();
    if ($model_shift) {
        foreach ($model_shift as $value) {
            $model_adust_qty = \common\models\CloseDailyAdjust::find()->where(['product_id' => $product_id, 'shift' => $value->shift])->andFilterWhere(['is not', 'cash_qty', new \yii\db\Expression('null')])->all();
            if ($model_adust_qty !=null) {
                foreach($model_adust_qty as $valuex){
                    $total_qty += ($valuex->cash_qty);
                }
            } else {
                $total_qty += $value->cash_qty;
            }
            //$total_qty = $total_qty +1;
        }

    }
    return $total_qty;
}

function getCreditQty($t_date, $product_id)
{
    $total_qty = 0;
    $total_qty2 = 0;

    $model_shift = \common\models\TransactionPosSaleSum::find()->where(['product_id' => $product_id, 'month(trans_date)' => date('m', strtotime($t_date)), 'year(trans_date)' => date('Y', strtotime($t_date))])->groupBy('shift')->all();
    if ($model_shift) {
        foreach ($model_shift as $value) {
            $model_adust_qty = \common\models\CloseDailyAdjust::find()->where(['product_id' => $product_id, 'shift' => $value->shift])->andFilterWhere(['is not', 'credit_qty', new \yii\db\Expression('null')])->all();
            if ($model_adust_qty !=null) {
                foreach($model_adust_qty as $valuex){
                    $total_qty += ($valuex->credit_qty);
                }
            } else {
                $total_qty += $value->credit_qty;
            }
            //$total_qty = $total_qty +1;
        }

    }
    return $total_qty;
}

function getIssueCarQty($t_date, $product_id)
{
    $total_qty = 0;
    $total_qty2 = 0;

    $model_shift = \common\models\TransactionPosSaleSum::find()->where(['product_id' => $product_id, 'month(trans_date)' => date('m', strtotime($t_date)), 'year(trans_date)' => date('Y', strtotime($t_date))])->groupBy('shift')->all();
    if ($model_shift) {
        foreach ($model_shift as $value) {
            $model_adust_qty = \common\models\CloseDailyAdjust::find()->where(['product_id' => $product_id, 'shift' => $value->shift])->andFilterWhere(['is not', 'issue_car_qty', new \yii\db\Expression('null')])->all();
            if ($model_adust_qty !=null) {
                foreach($model_adust_qty as $valuex){
                    $total_qty += ($valuex->issue_car_qty);
                }
                // $total_qty+=$model_adust_qty;
            } else {
                $total_qty += $value->issue_car_qty;
            }
            //$total_qty = $total_qty +1;
        }

    }
    return $total_qty;
}

function getIssueTransferQty($t_date, $product_id)
{
    $total_qty = 0;
    $total_qty2 = 0;

    $model_shift = \common\models\TransactionPosSaleSum::find()->where(['product_id' => $product_id, 'month(trans_date)' => date('m', strtotime($t_date)), 'year(trans_date)' => date('Y', strtotime($t_date))])->groupBy('shift')->all();
    if ($model_shift) {
        foreach ($model_shift as $value) {
            $model_adust_qty = \common\models\CloseDailyAdjust::find()->where(['product_id' => $product_id, 'shift' => $value->shift])->andFilterWhere(['is not', 'issue_transfer_qty', new \yii\db\Expression('null')])->all();
            if ($model_adust_qty !=null) {
                foreach($model_adust_qty as $valuex){
                    $total_qty += ($valuex->issue_transfer_qty);
                }
            } else {
                $total_qty += $value->issue_transfer_qty;
            }
            //$total_qty = $total_qty +1;
        }

    }
    return $total_qty;
}

function getFreeQty($t_date, $product_id)
{
    $data = [];
    $qty = 0;
    $sql = "SELECT sum(car_qty) as car_qty
              FROM transaction_manager_daily as t1
             WHERE  year(t1.trans_date) =" . "'" . date('Y', strtotime($t_date)) . "'" . " 
             AND month(t1.trans_date) =" . "'" . date('m', strtotime($t_date)) . "'" . " 
             AND t1.product_id=" . $product_id;
    $sql .= " AND t1.price = 0";
    $sql .= " GROUP BY t1.product_id";
    $query = \Yii::$app->db->createCommand($sql);
    $model = $query->queryAll();
    if ($model) {
        for ($i = 0; $i <= count($model) - 1; $i++) {
            $qty = $model[$i]['car_qty'];
        }
    }
    return $qty;
}

function getSaleCarQty($t_date, $product_id)
{
    $data = [];
    $qty = 0;

    $check_has_edit = \common\models\CloseMonthlyQuantity::find()->where(['year(trans_date)' => date('Y', strtotime($t_date)), 'month(trans_date)' => date('m', strtotime($t_date)), 'product_id' => $product_id])->one();
    if($check_has_edit){
        $qty = $check_has_edit->qty;
        array_push($data,['qty'=>$qty,'is_edit'=>1]);
    }else {
        $sql = "SELECT sum(car_qty) as car_qty
              FROM transaction_manager_daily as t1
             WHERE  year(t1.trans_date) =" . "'" . date('Y', strtotime($t_date)) . "'" . " 
             AND month(t1.trans_date) =" . "'" . date('m', strtotime($t_date)) . "'" . " 
             AND t1.product_id=" . $product_id;
        $sql .= " GROUP BY t1.product_id";
        $query = \Yii::$app->db->createCommand($sql);
        $model = $query->queryAll();
        if ($model) {
            for ($i = 0; $i <= count($model) - 1; $i++) {
                $qty = $model[$i]['car_qty'];
                array_push($data,['qty'=>$qty,'is_edit'=>0]);
            }
        }
    }
    return $data;
}

function getBalanceInQty($t_date, $product_id)
{
    $total_qty = 0;
    $total_qty2 = 0;

    $model_shift = \common\models\TransactionPosSaleSum::find()->where(['product_id' => $product_id, 'month(trans_date)' => date('m', strtotime($t_date)), 'year(trans_date)' => date('Y', strtotime($t_date))])->orderBy(['id' => SORT_ASC])->one();
    if ($model_shift) {
        //foreach ($model_shift as $value){
        $model_adust_qty = \common\models\CloseDailyAdjust::find()->where(['product_id' => $product_id, 'shift' => $model_shift->shift])->andFilterWhere(['is not', 'balance_in_qty', new \yii\db\Expression('null')])->sum('balance_in_qty');
        if ($model_adust_qty) {
            if ($model_adust_qty >= 0 || $model_adust_qty != null) {
                $total_qty += $model_adust_qty;
            }
            // $total_qty+=$model_adust_qty;
        } else {
            $total_qty += $model_shift->balance_in_qty;
        }
        //$total_qty = $total_qty +1;
        //}

    }
    return $total_qty;
}

function getBalanceOutQty($t_date, $product_id)
{
    $total_qty = 0;
    $total_qty2 = 0;

    $model_shift = \common\models\TransactionPosSaleSum::find()->where(['product_id' => $product_id, 'month(trans_date)' => date('m', strtotime($t_date)), 'year(trans_date)' => date('Y', strtotime($t_date))])->orderBy(['id' => SORT_DESC])->one();
    if ($model_shift) {
        $total_qty += $model_shift->counting_qty;
    }
    return $total_qty;
}

function getScrapQty($t_date, $product_id)
{
    $total_qty = 0;

    $model_shift = \common\models\TransactionPosSaleSum::find()->where(['product_id' => $product_id, 'month(trans_date)' => date('m', strtotime($t_date)), 'year(trans_date)' => date('Y', strtotime($t_date))])->groupBy('shift')->all();
    if ($model_shift) {
        foreach ($model_shift as $value) {
            $model_adust_qty = \common\models\CloseDailyAdjust::find()->where(['product_id' => $product_id, 'shift' => $value->shift])->andFilterWhere(['is not', 'scrap_qty', new \yii\db\Expression('null')])->sum('scrap_qty');
            if ($model_adust_qty) {
                if ($model_adust_qty >= 0 || $model_adust_qty != null) {
                    $total_qty += $model_adust_qty;
                }
                // $total_qty+=$model_adust_qty;
            } else {
                $total_qty += $value->scrap_qty;
            }
            //$total_qty = $total_qty +1;
        }

    }
    return $total_qty;
}

function getIssueRefillQty($t_date, $product_id)
{
    $total_qty = 0;

    $model_shift = \common\models\TransactionPosSaleSum::find()->where(['product_id' => $product_id, 'month(trans_date)' => date('m', strtotime($t_date)), 'year(trans_date)' => date('Y', strtotime($t_date))])->groupBy('shift')->all();
    if ($model_shift) {
        foreach ($model_shift as $value) {
            $model_adust_qty = \common\models\CloseDailyAdjust::find()->where(['product_id' => $product_id, 'shift' => $value->shift])->andFilterWhere(['is not', 'refill_qty', new \yii\db\Expression('null')])->all();
            if ($model_adust_qty) {
                foreach($model_adust_qty as $value){
                    $total_qty += ($value->refill_qty);
                }
                // $total_qty+=$model_adust_qty;
            } else {
                $total_qty += $value->issue_refill_qty;
            }
            //$total_qty = $total_qty +1;
        }

    }
    return $total_qty;
}


?>
<?php
$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/jquery.table2excel.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$url_to_edit_qty = \yii\helpers\Url::to(['adminreport/saveeditqty'],true);
$js = <<<JS
 $(function(){
      
     $("#table-data tr.line-detail-sum").each(function(){
         var header_product = $(this).attr('data-var');
         var line_qty = 0;
         var line_qty2 = 0;
         var line_qty5 = 0;
         var line_qty4 = 0;
         var line_total_qty = 0;
         var line_amount = 0;
         var line_amount2 = 0;
         var line_amount5 = 0;
         var line_amount4 = 0;
         var line_total_amount = 0;
         $("#table-data tr.line-detail").each(function(){
             var line_product = $(this).attr('data-var');
             if(line_product == header_product){
                // line_qty = parseFloat(line_qty) + parseFloat($(this).closest('tr').find('.line-qty').val());
                 line_qty = parseFloat(line_qty) + parseFloat($(this).closest('tr').find('td:eq(3)').html().replace(',','').replace(',',''));
                 line_qty2 = parseFloat(line_qty2) + parseFloat($(this).closest('tr').find('td:eq(4)').html().replace(',','').replace(',',''));
                 line_qty5 = parseFloat(line_qty5) + parseFloat($(this).closest('tr').find('td:eq(5)').html().replace(',','').replace(',',''));
                 line_qty4 = parseFloat(line_qty4) + parseFloat($(this).closest('tr').find('td:eq(6)').html().replace(',','').replace(',',''));
                 line_total_qty = parseFloat(line_total_qty) + parseFloat($(this).closest('tr').find('td:eq(7)').html().replace(',','').replace(',',''));
                 
                 line_amount = parseFloat(line_amount) + parseFloat($(this).closest('tr').find('td:eq(8)').html().replace(',','').replace(',',''));
                 line_amount2 = parseFloat(line_amount2) + parseFloat($(this).closest('tr').find('td:eq(9)').html().replace(',','').replace(',',''));
                 line_amount5 = parseFloat(line_amount5) + parseFloat($(this).closest('tr').find('td:eq(10)').html().replace(',','').replace(',',''));
                 line_amount4 = parseFloat(line_amount4) + parseFloat($(this).closest('tr').find('td:eq(11)').html().replace(',','').replace(',',''));
                 line_total_amount = parseFloat(line_total_amount) + parseFloat($(this).closest('tr').find('td:eq(12)').html().replace(',','').replace(',',''));
             }
             
         });
        
        $(this).closest('tr').find('td:eq(3)').html(addCommas(parseFloat(line_qty).toFixed(2)));
        $(this).closest('tr').find('td:eq(4)').html(addCommas(parseFloat(line_qty2).toFixed(2)));
        $(this).closest('tr').find('td:eq(5)').html(addCommas(parseFloat(line_qty5).toFixed(2)));
        $(this).closest('tr').find('td:eq(6)').html(addCommas(parseFloat(line_qty4).toFixed(2)));
        $(this).closest('tr').find('td:eq(7)').html(addCommas(parseFloat(line_total_qty).toFixed(2)));
        
        $(this).closest('tr').find('td:eq(8)').html(addCommas(parseFloat(line_amount).toFixed(2)));
        $(this).closest('tr').find('td:eq(9)').html(addCommas(parseFloat(line_amount2).toFixed(2)));
        $(this).closest('tr').find('td:eq(10)').html(addCommas(parseFloat(line_amount5).toFixed(2)));
        $(this).closest('tr').find('td:eq(11)').html(addCommas(parseFloat(line_amount4).toFixed(2)));
        $(this).closest('tr').find('td:eq(12)').html(addCommas(parseFloat(line_total_amount).toFixed(2)));
     });
 });
 $("#btn-export-excel").click(function(){
  $("#table-data").table2excel({
    // exclude CSS class
    exclude: ".noExl",
    name: "Excel Document Name"
  });
});
$(".btn-order-date").click(function(){
    $(".btn-order-type").val(1);
    if($(".btn-order-price").hasClass("btn-success")){
        $(".btn-order-price").removeClass("btn-success");
        $(".btn-order-price").addClass("btn-default");
    }
    if($(this).hasClass("btn-default")){
        $(this).removeClass("btn-default")
        $(this).addClass("btn-success");
    }
    
});
$(".btn-order-price").click(function(){
    $(".btn-order-type").val(2);
      if($(".btn-order-date").hasClass("btn-success")){
        $(".btn-order-date").removeClass("btn-success");
        $(".btn-order-date").addClass("btn-default");
    }
    if($(this).hasClass("btn-default")){
        $(this).removeClass("btn-default")
        $(this).addClass("btn-success");
    }
});
function printContent(el)
      {
         var restorepage = document.body.innerHTML;
         var printcontent = document.getElementById(el).innerHTML;
         document.body.innerHTML = printcontent;
         window.print();
         document.body.innerHTML = restorepage;
     }
function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
 }
 
 function editLineQty(e){
     var trans_date = $(".line-trans-date").val();
     var product_id = e.closest("tr").find(".line-product-id").val();
     var qty = e.closest("tr").find(".line-new-qty").val();
     if(product_id >0){
         $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_edit_qty",
              'data': {'product_id': product_id,'trans_date': trans_date,'qty': qty},
              'success': function(data) {
                    //alert(data);
                 window.location.reload();
                 }
              }); 
     }
 }
JS;
$this->registerJs($js, static::POS_END);
?>
