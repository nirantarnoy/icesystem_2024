<?php
date_default_timezone_set('Asia/Bangkok');

use chillerlan\QRCode\QRCode;
use common\models\LoginLog;
use common\models\QuerySaleorderByCustomerLoanSumNew;
use kartik\daterange\DateRangePicker;
use yii\web\Response;

//require_once __DIR__ . '/vendor/autoload.php';
//require_once 'vendor/autoload.php';
// เพิ่ม Font ให้กับ mPDF

$user_id = \Yii::$app->user->id;
$is_admin = \backend\models\User::checkIsAdmin(\Yii::$app->user->identity->id);

/* Unused mPDF initialization removed for performance
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
*/

//// check date
//$restrict_date = date('Y-m-d', strtotime('-2 months'));
//$date1 = new DateTime($from_date);
//$date2 = new DateTime($to_date);
//$diff = $date1->diff($date2);
//$diff_month = ($diff->y * 12) + $diff->m;
//
//if($is_admin == 1){
//    $from_date = $from_date;
//    $to_date = $to_date;
//}else{
//    if ($to_date < $restrict_date) {
//        $from_date = null;
//        $to_date = null;
//    } else {
//        if ($diff_month >= 2) {
//            if ($from_date < $restrict_date) {
//                $from_date = $restrict_date;
//                $to_date = $to_date;
//            } else {
//                $from_date = $from_date;
//                $to_date = $to_date;
//            }
//
//        } else {
//            $from_date = $from_date;
//            $to_date = $to_date;
//        }
//    }
//}
//// end check date

$f_date = date('Y-m-d 00:00:00', strtotime($from_date));
$t_date = date('Y-m-d 23:59:59', strtotime($to_date));
$query_date = date('Y-m-d', strtotime($from_date));

$model_line = \common\models\QuerySaleMobileDataNew::find()
    ->select(['route_id'])
    ->where(['BETWEEN', 'order_date', $f_date, $t_date])
    ->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])
    ->orderBy(['route_id' => SORT_ASC])
    ->groupBy('route_id')
    ->asArray()
    ->all();

$route_ids = [];
foreach ($model_line as $val) {
    if ($val['route_id'] && !in_array($val['route_id'], $route_ids)) {
        $route_ids[] = (int)$val['route_id'];
    }
}

$trans_stats = [];
$transfer_stats = [];
$pay_stats = [];
$car_stats = [];
$not_full_pay_stats = [];
$route_name_map = [];

if (!empty($route_ids)) {
    $trans_data = \common\models\TransactionCarSale::find()
        ->select([
            'route_id',
            'SUM(credit_qty + cash_qty) as total_qty',
            'SUM(cash_amount) as total_cash_amount',
            'SUM(credit_amount) as total_credit_amount',
            'SUM(free_qty) as total_free_qty'
        ])
        ->where(['BETWEEN', 'trans_date', $f_date, $t_date])
        ->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])
        ->andWhere(['route_id' => $route_ids])
        ->groupBy('route_id')
        ->asArray()
        ->all();
    $trans_stats = \yii\helpers\ArrayHelper::index($trans_data, 'route_id');

    $transfer_data = \common\models\QuerySaleMobileDataNew::find()
        ->select([
            'route_id',
            'SUM(line_total_cash_transfer) as total_cash_transfer'
        ])
        ->where(['BETWEEN', 'order_date', $f_date, $t_date])
        ->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])
        ->andWhere(['route_id' => $route_ids])
        ->groupBy('route_id')
        ->asArray()
        ->all();
    $transfer_stats = \yii\helpers\ArrayHelper::index($transfer_data, 'route_id');

    $pay_data = \common\models\TransactionCarSaleRoutePay::find()
        ->select([
            'route_id',
            'SUM(cash_amount) as receive_cash',
            'SUM(transfer_amount) as receive_transfer'
        ])
        ->where(['BETWEEN', 'trans_date', $f_date, $t_date])
        ->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])
        ->andWhere(['route_id' => $route_ids])
        ->groupBy('route_id')
        ->asArray()
        ->all();
    $pay_stats = \yii\helpers\ArrayHelper::index($pay_data, 'route_id');

    $car_data = \common\models\QueryCarEmpData::find()
        ->where(['date(trans_date)' => $query_date]) // View might only support date() or be small
        ->andWhere(['id' => $route_ids])
        ->asArray()
        ->all();
    $car_stats = \yii\helpers\ArrayHelper::index($car_data, 'id');

    $not_full_pay_data = \common\models\DeliveryNotFullPay::find()
        ->where(['date(trans_date)' => $query_date])
        ->andWhere(['route_id' => $route_ids])
        ->asArray()
        ->all();
    $not_full_pay_stats = \yii\helpers\ArrayHelper::index($not_full_pay_data, 'route_id');

    $route_names = \backend\models\Deliveryroute::find()
        ->select(['id', 'name'])
        ->where(['id' => $route_ids])
        ->asArray()
        ->all();
    $route_name_map = \yii\helpers\ArrayHelper::index($route_names, 'id');
}



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
            font-size: 14px;
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
            border: 0px;
            border-spacing: 0px;
        }

        table.table-title td, th {
            border: 0px solid #dddddd;
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
<body>
<div class="row">
    <div class="col-lg-9">
        <form action="<?= \yii\helpers\Url::to(['adminreport/cardailyamount'], true) ?>" method="post" id="form-search">
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
                    <td style="width: 20%">
                        <?php
                        echo DateRangePicker::widget([
                            'name' => 'to_date',
                            'value' => $to_date != null ? date('Y-m-d H:i', strtotime($to_date)) : date('Y-m-d H:i'),
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

                    <!--            <td>-->
                    <!--                --><?php
                    //                echo \kartik\select2\Select2::widget([
                    //                    'name' => 'find_emp_id',
                    //                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', 'name'),
                    //                    'value' => $find_emp_id,
                    //                    'options' => [
                    //                        'placeholder' => '--สายส่ง--'
                    //                    ],
                    //                    'pluginOptions' => [
                    //                        'allowClear' => true,
                    //                        'multiple' => true,
                    //                    ]
                    //                ]);
                    //                ?>
                    <!--            </td>-->
                    <td>
                        <input type="submit" class="btn btn-primary" value="ค้นหา">
                    </td>
                    <td style="width: 25%; text-align: right">

                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="col-lg-3" style="text-align: right;">
        <form action="<?=\yii\helpers\Url::to(['site/transactionsalecar'],true)?>" method="post">
            <div class="input-group">
                <?php
                echo DateRangePicker::widget([
                    'name' => 'cal_date',
                    'value' => date('Y-m-d'),
                    //    'useWithAddon'=>true,
                    'convertFormat' => true,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => '',
                        //  'onchange' => 'this.form.submit();',
                        'autocomplete' => 'off',
                    ],
                    'pluginOptions' => [
                        'timePicker' => false,
                        'timePickerIncrement' => 1,
                        'locale' => ['format' => 'Y-m-d'],
                        'singleDatePicker' => true,
                        'showDropdowns' => true,
                        'timePicker24Hour' => true
                    ]
                ]);
                ?>
                <button class="btn btn-outline-success">
                    <i class="fa fa-refresh"></i> ประมวลผล
                </button>
            </div>
        </form>

    </div>
</div>
<br/>
<div id="div1">
    <table class="table-header" width="100%">
        <tr>
            <td style="text-align: center; font-size: 20px; font-weight: bold">รายงานสรุปขายแยกสายส่ง</td>
        </tr>
    </table>
    <br>
    <table class="table-header" width="100%">
        <tr>
            <td style="text-align: center; font-size: 20px; font-weight: normal">
                จากวันที่ <span style="color: red"><?= date('Y-m-d H:i', strtotime($from_date)) ?></span>
                ถึง <span style="color: red"><?= date('Y-m-d H:i', strtotime($to_date)) ?></span></td>
        </tr>
    </table>
    <br>
    <?php
    $total_all = 0;
    $count_item = 0;
    $num = 0;
    $total_line = 0;
    $line_qty = 0;
    $total_line_qty = 0;
    $total_all_line_qty = 0;

    $all_qty = 0;
    $all_cash = 0;
    $all_credit = 0;
    $all_cash_transfer = 0;

    $all_free = 0;
    $all_receive_cash = 0;
    $all_receive_transfer = 0;

    $product_header = [];

    $all_not_full_amount = 0;
    $all_cash_transfer_amount = 0;



    // print_r($product_header);


    ?>
    <table id="table-data">
        <tr style="font-weight: bold;">
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">สายส่ง</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">ทะเบียน</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">พนักงานขับรถ</td>
            <td style="text-align: right;padding: 8px;border: 1px solid grey;">ขายสด</td>
            <td style="text-align: right;padding: 8px;border: 1px solid grey;">ขายสดโอน</td>
            <td style="text-align: right;padding: 8px;border: 1px solid grey;">ขายเชื่อ</td>
            <td style="text-align: right;padding: 8px;border: 1px solid grey;">ชำระหนี้สด</td>
            <td style="text-align: right;padding: 8px;border: 1px solid grey;">ชำระหนี้โอน</td>
            <td style="text-align: right;padding: 8px;border: 1px solid grey;background-color: mediumseagreen">รวมเงินสด
            </td>
            <td style="text-align: right;padding: 8px;border: 1px solid grey;background-color: mediumseagreen">เงินขาด
            </td>
            <td style="text-align: right;padding: 8px;border: 1px solid grey;background-color: mediumseagreen">สดโอน
            </td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;background-color: mediumseagreen">ตรวจสอบ</td>
        </tr>

        <?php foreach ($model_line as $value): ?>
            <?php
            $num += 1;
            $route_id = $value['route_id'];

            $stats = isset($trans_stats[$route_id]) ? $trans_stats[$route_id] : null;
            $transfers = isset($transfer_stats[$route_id]) ? $transfer_stats[$route_id] : null;
            $pays = isset($pay_stats[$route_id]) ? $pay_stats[$route_id] : null;
            $car = isset($car_stats[$route_id]) ? $car_stats[$route_id] : null;
            $not_pay = isset($not_full_pay_stats[$route_id]) ? $not_full_pay_stats[$route_id] : null;

            $line_qty_total = $stats ? (float)$stats['total_qty'] : 0;
            $line_cash_amount_total = $stats ? (float)$stats['total_cash_amount'] : 0;
            $line_credit_amount_total = $stats ? (float)$stats['total_credit_amount'] : 0;
            $product_line_free_qty = $stats ? (float)$stats['total_free_qty'] : 0;

            $line_cash_transfer_amount_total = $transfers ? (float)$transfers['total_cash_transfer'] : 0;

            $product_line_receive_cash = $pays ? (float)$pays['receive_cash'] : 0;
            $product_line_receive_transfer = $pays ? (float)$pays['receive_transfer'] : 0;

            $car_name = $car ? $car['car_name_'] : '';
            $emp_name = $car ? $car['fname'] : '';

            $line_transfer_note = '';
            $line_not_full_amount = 0;
            $line_cash_transfer_amount = 0;
            if ($not_pay) {
                $line_not_full_amount = (float)$not_pay['not_full_amount'];
                $line_cash_transfer_amount = (float)$not_pay['cash_transfer_amount'];
                $all_not_full_amount += $line_not_full_amount;
                $all_cash_transfer_amount += $line_cash_transfer_amount;
                $line_transfer_note = $not_pay['payment_name'] . ' ' . $not_pay['payment_account'];
            }

            $all_free += $product_line_free_qty;
            $all_receive_cash += $product_line_receive_cash;
            $all_receive_transfer += $product_line_receive_transfer;
            $all_qty += $line_qty_total;
            $all_cash += $line_cash_amount_total;
            $all_cash_transfer += $line_cash_transfer_amount_total;
            $all_credit += $line_credit_amount_total;

            ?>
            <tr ondblclick="showedit($(this))" data-var="<?= $route_id ?>" data-date="<?= $from_date ?>">
                <td style="text-align: left;padding: 8px;border: 1px solid grey"><?= isset($route_name_map[$route_id]) ? $route_name_map[$route_id]['name'] : '' ?></td>

                <td style="text-align: left;padding: 8px;border: 1px solid grey"><?= $car_name ?></td>
                <td style="text-align: left;padding: 8px;border: 1px solid grey"><?= $emp_name ?></td>
                <td style="text-align: right;padding: 8px;padding-right: 5px;border: 1px solid grey"><?= $line_cash_amount_total == 0 ? "-" : number_format($line_cash_amount_total - $line_cash_transfer_amount_total, 2) ?></td>
                <td style="text-align: right;padding: 8px;padding-right: 5px;border: 1px solid grey"><?= $line_cash_transfer_amount_total == 0 ? "-" : number_format($line_cash_transfer_amount_total, 2) ?></td>
                <td style="text-align: right;padding: 8px;padding-right: 5px;border: 1px solid grey"><?= $line_credit_amount_total == 0 ? "-" : number_format($line_credit_amount_total, 2) ?></td>
                <td style="text-align: right;padding: 8px;padding-right: 5px;border: 1px solid grey"><?= $product_line_receive_cash == 0 ? "-" : number_format($product_line_receive_cash - $line_cash_transfer_amount_total, 2) ?></td>
                <td style="text-align: right;padding: 8px;padding-right: 5px;border: 1px solid grey"><?= $product_line_receive_transfer == 0 ? "-" : number_format($product_line_receive_transfer, 2) ?></td>
                <td style="text-align: right;padding: 8px;padding-right: 5px;border: 1px solid grey;background-color: mediumseagreen;font-weight: bold;"><?= number_format(($line_cash_amount_total + $product_line_receive_cash - $line_cash_transfer_amount_total), 2) ?></td>
                <td style="text-align: right;padding: 8px;padding-right: 5px;border: 1px solid grey;font-weight: bold;color: red;"><?= $line_not_full_amount != 0 ? number_format($line_not_full_amount, 2) : '-' ?></td>
                <td style="text-align: right;padding: 8px;padding-right: 5px;border: 1px solid grey;font-weight: bold;color: red;"><?= $line_cash_transfer_amount != 0 ? number_format($line_cash_transfer_amount, 2) : '-' ?></td>
                <td style="text-align: left;padding: 8px;border: 1px solid grey;">
                    <?= $line_transfer_note ?>
                </td>
            </tr>
        <?php endforeach; ?>

        <tfoot>
        <tr>
            <td colspan="2"
                style="text-align: left;padding: 0px;text-indent: 15px;border: 0px solid grey;padding: 10px;">
                <input type="hidden" class="all-line-total" value="<?=($all_cash + $all_receive_cash - $all_cash_transfer)?>">
            </td>
            <td style="text-align: right;padding: 5px;border: 0px solid grey"><b>รวม</b></td>
            <td style="text-align: right;padding: 2px;padding-right: 5px;border: 1px solid grey"><b><?= number_format($all_cash - $all_cash_transfer, 2) ?></b></td>
            <td style="text-align: right;padding: 2px;padding-right: 5px;border: 1px solid grey"><b><?= number_format($all_cash_transfer, 2) ?></b></td>
            <td style="text-align: right;padding: 2px;padding-right: 5px;border: 1px solid grey"><b><?= number_format($all_credit, 2) ?></b></td>
            <td style="text-align: right;padding: 2px;padding-right: 5px;border: 1px solid grey"><b><?= number_format($all_receive_cash - $all_cash_transfer, 2) ?></b></td>
            <td style="text-align: right;padding: 2px;padding-right: 5px;border: 1px solid grey"><b><?= number_format($all_receive_transfer, 2) ?></b></td>
            <td style="text-align: right;padding: 2px;padding-right: 5px;border: 1px solid grey;background-color: mediumseagreen"><b><?= number_format(($all_cash + $all_receive_cash - $all_cash_transfer), 2) ?></b></td>
            <td style="text-align: right;padding: 8px;padding-right: 5px;border: 1px solid grey;font-weight: bold;color: red;"><?=$all_not_full_amount!=0?number_format($all_not_full_amount,2):'-'?></td>
            <td style="text-align: right;padding: 8px;padding-right: 5px;border: 1px solid grey;font-weight: bold;color: red;"><?=$all_cash_transfer_amount!=0?number_format($all_cash_transfer_amount,2):'-'?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="7">
                <table style="border: 0px;width: 100%">
                    <tr>
                        <td style="text-align: right;vertical-align: middle"><span class="show-title-text"></span></td>
                        <td style="vertical-align: middle"><span class="show-title-amount"></span></td>
                        <td style="text-align: right;vertical-align: middle"><span><b>หักสดโอน</b></span></td>
                        <td style="vertical-align: middle"><span class="show-deduct"></span></td>
                        <td style="text-align: right;vertical-align: middle"><span><b>VP18</b></span></td>
                        <td style="text-align: right;vertical-align: middle">
                            <span class="all-vp18"></span>
                            </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </td>
            <td style="text-align: right;background-color: yellow">
                <b><span class="all-total">0</span></b>
            </td>
        </tr>
        </tfoot>
    </table>
</div>

<br/>
<table width="100%" class="table-title">
    <td style="text-align: right">
        <button id="btn-export-excel" class="btn btn-secondary">Export Excel</button>
        <button id="btn-print" class="btn btn-warning" onclick="printContent('div1')">Print</button>
    </td>
</table>
<div class="row">
    <div class="col-lg-12">
        <table style="border: 0px;width: 100%">
            <tr>
                <td style="text-align: right;vertical-align: middle"><input type="text" class="form-control show-title" onchange="cal_all($(this))"  placeholder="รายการหัก"></td>
                <td><input type="text" class="form-control all-deduct-amount" value="0" onchange="cal_all($(this))"></td>
                <td style="text-align: right"><b>หักสดโอน</b></td>
                <td><input type="text" class="form-control all-deduct-cash-amount" value="0" onchange="cal_all($(this))"></td>
                <td style="text-align: right"><b>VP18</b></td>
                <td style="text-align: right;">
                    <input type="text" class="form-control all-add-amount" value="0" onchange="cal_all($(this))"></td>
            </tr>
        </table>
    </div>
</div>

<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2b669a">
                <div class="row" style="text-align: center;width: 100%;color: white">
                    <div class="col-lg-12">
                        <span><h3 class="popup-product" style="color: white">ปรับจำนวน</h3></span>
                    </div>
                </div>
            </div>
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->
            <form id="form-edit-summary" action="<?= \yii\helpers\Url::to(['adminreport/addlinenote'], true) ?>"
                  method="post">
                <input type="hidden" name="add_line_date" class="add-line-date" value="">
                <input type="hidden" name="route_id" class="route-id" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">จำนวนเงินขาด</label>
                            <input type="text" class="form-control" name="add_amount" value="">
                        </div>
                        <div class="col-lg-4">
                            <label for="">จำนวนเงินสดโอน</label>
                            <input type="text" class="form-control" name="cash_transfer_amount" value="">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">ชื่อผู้โอน</label>
                            <input type="text" class="form-control" name="payment_name" value="">
                        </div>
                        <div class="col-lg-4">
                            <label for="">เลขที่บัญชี</label>
                            <input type="text" class="form-control" name="payment_account" value="">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-success btn-add-cart" data-dismiss="modalx"><i
                                class="fa fa-check"></i> บันทึกรายการ
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-close text-danger"></i> ยกเลิก
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
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
</body>
</html>

<?php
function getNotfullpay($route_id,$trans_date){
    $data = [];
    if($route_id){
        $ex = explode(' ',$trans_date);
        $ex2 = null;
        $t_date = null;
        if($ex!=null){
            $ex2 = explode('-',$ex[0]);

            //   print_r($ex2);return;
            if($ex2!=null){
                if(count($ex2)>1){
                    $t_date = $ex2[2].'-'.$ex2[1].'-'.$ex2[0];
                }

            }
        }
        if($t_date!=null){
            $model = \common\models\DeliveryNotFullPay::find()->where(['route_id'=>$route_id,'date(trans_date)'=>date('Y-m-d',strtotime($t_date))])->one();
            if($model){
                array_push($data,['not_full_amount'=>$model->not_full_amount,'cash_transfer_amount'=>$model->cash_transfer_amount,'payment_name'=>$model->payment_name,'payment_account'=>$model->payment_account]);
            }
        }
    }
    return $data;
}
function getOrderQty2($route_id, $product_id, $from_date, $to_date, $company_id, $branch_id)
{
    $data = 0;
    if ($route_id && $product_id) {
         $model_qty = \common\models\TransactionCarSale::find()->select(['SUM(credit_qty) as credit_qty', 'SUM(cash_qty) as cash_qty'])->where(['BETWEEN', 'date(trans_date)', date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))])
            ->andFilterWhere(['route_id' => $route_id, 'product_id' => $product_id, 'company_id' => $company_id, 'branch_id' => $branch_id])->groupBy(['product_id'])->one();
        if ($model_qty != null) {
            $data = ($model_qty->credit_qty + $model_qty->cash_qty);
        }
    }
    return $data;
}
function getFree($route_id, $from_date, $to_date, $company_id, $branch_id){
    $data = 0;
    if ($route_id) {
        $model_qty = \common\models\TransactionCarSale::find()->select(['SUM(free_qty) as free_qty'])->where(['BETWEEN', 'date(trans_date)', date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))])
            ->andFilterWhere(['route_id' => $route_id, 'company_id' => $company_id, 'branch_id' => $branch_id])->groupBy(['route_id'])->one();
        if ($model_qty != null) {
            $data = ($model_qty->free_qty);
        }
    }
    return $data;
}
function getPayment($f_date, $t_date, $find_user_id, $company_id, $branch_id)
{
    $list_route_id = null;

    $data = [];
    $amount = 0;

    $sql = "SELECT SUM(t1.payment_amount) as amount  from query_payment_receive as t1 INNER JOIN customer as t2 on t2.id = t1.customer_id 
              WHERE (date(t1.trans_date)>= " . "'" . date('Y-m-d', strtotime($f_date)) . "'" . " 
              AND date(t1.trans_date)<= " . "'" . date('Y-m-d', strtotime($t_date)) . "'" . " )
              AND t1.status <> 100 
              AND t1.payment_method_id=2 AND  t2.delivery_route_id =".$find_user_id."
              AND t1.company_id=" . $company_id . " AND t1.branch_id=" . $branch_id;



    $sql .= " GROUP BY t1.route_id";
    $query = \Yii::$app->db->createCommand($sql);
    $model = $query->queryAll();
    if ($model) {
        for ($i = 0; $i <= count($model) - 1; $i++) {
//            array_push($data, [
//                'pay' => $model[$i]['amount'],
//            ]);
            $amount = $model[$i]['amount'];
        }
    }
    return $amount;
}
//function getReceiveCash($route_id, $from_date, $to_date){ // from transaction
//    $data = 0;
//    if ($route_id) {
//        $model_qty = \common\models\QueryPaymentReceive::find()->select(['SUM(payment_amount) as payment_amount'])->where(['BETWEEN', 'date(trans_date)', date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))])
//            ->andFilterWhere(['payment_method_id'=>2])
//            ->andFilterWhere(['!=','status',100])
//            ->andFilterWhere(['route_id' => $route_id])->groupBy(['route_id'])->one();
//        if ($model_qty != null) {
//            $data = ($model_qty->payment_amount);
//        }
//    }
//    return $data;
//}

function getCashAmount($route_id, $product_id, $from_date, $to_date, $company_id, $branch_id){
    $data = 0;
    if ($route_id && $product_id) {
        $model_qty = \common\models\TransactionCarSale::find()->select(['SUM(cash_amount) as cash_amount'])->where(['BETWEEN', 'date(trans_date)', date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))])
            ->andFilterWhere(['route_id' => $route_id, 'product_id' => $product_id, 'company_id' => $company_id, 'branch_id' => $branch_id])->groupBy(['product_id'])->one();
        if ($model_qty != null) {
            $data = ($model_qty->cash_amount);
        }
    }
    return $data;
}
function getCashTransferAmount($route_id, $product_id, $from_date, $to_date, $company_id, $branch_id){
    $data = 0;
    if ($route_id && $product_id) {
        $data = \common\models\QuerySaleMobileDataNew::find()
            ->where(['BETWEEN', 'date(order_date)', date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))])
            ->andFilterWhere(['route_id' => $route_id, 'product_id' => $product_id, 'company_id' => $company_id, 'branch_id' => $branch_id])
            ->sum('line_total_cash_transfer');
    }
    return $data;
}
function getCreditAmount($route_id, $product_id, $from_date, $to_date, $company_id, $branch_id){
    $data = 0;
    if ($route_id && $product_id) {
        $model_qty = \common\models\TransactionCarSale::find()->select(['SUM(credit_amount) as credit_amount'])->where(['BETWEEN', 'date(trans_date)', date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))])
            ->andFilterWhere(['route_id' => $route_id, 'product_id' => $product_id, 'company_id' => $company_id, 'branch_id' => $branch_id])->groupBy(['product_id'])->one();
        if ($model_qty != null) {
            $data = ($model_qty->credit_amount);
        }
    }
    return $data;
}
function getReceiveCash($route_id, $from_date, $to_date, $company_id, $branch_id)
{
    $data = 0;
    if ($route_id) {
        $model_qty = \common\models\TransactionCarSaleRoutePay::find()
            ->where(['BETWEEN', 'date(trans_date)', date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))])
            ->andFilterWhere(['route_id' => $route_id, 'company_id' => $company_id, 'branch_id' => $branch_id])->sum('cash_amount');
        if ($model_qty != null) {
            $data = ($model_qty);
        }
    }
    return $data;
}

function getReceiveTransfer($route_id, $from_date, $to_date, $company_id, $branch_id)
{
    $data = 0;
    if ($route_id) {
        $model_qty = \common\models\TransactionCarSaleRoutePay::find()
            ->where(['BETWEEN', 'date(trans_date)', date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))])
            ->andFilterWhere(['route_id' => $route_id, 'company_id' => $company_id, 'branch_id' => $branch_id])->sum('transfer_amount');
        if ($model_qty != null) {
            $data = ($model_qty);
        }
    }
    return $data;
}
function getCardata($route_id,$t_date){
    $data = [];
    if($route_id){
        $model = \common\models\QueryCarEmpData::find()->where(['date(trans_date)'=>date('Y-m-d',strtotime($t_date)),'id'=>$route_id])->one();
        if($model){
            array_push($data,[
                    'car_name'=>$model->car_name_,
                'emp_name'=>$model->fname,
            ]);
        }
    }
    return $data;
}

?>

<?php
$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/jquery.table2excel.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$js = <<<JS
 $(function(){
    $("#btn-export-excel").click(function(){
          $("#table-data").table2excel({
            // exclude CSS class
            exclude: ".noExl",
            name: "Excel Document Name"
          });
    });
 });
function cal_all(e){
    var show_title = $(".show-title").val();
    var total = $(".all-line-total").val();
    var c_amount = $(".all-add-amount").val();
    var deduct_amount = $(".all-deduct-amount").val();
    var deduct_cash_amount = $(".all-deduct-cash-amount").val();
    
    $(".show-title-text").html(show_title);
    $(".show-title-amount").html(deduct_amount);
    $(".show-deduct").html(deduct_cash_amount);
    $(".all-vp18").html(c_amount);
    
    $(".all-total").html(addCommas(parseFloat(parseFloat(total) + parseFloat(c_amount) - parseFloat(deduct_amount)- parseFloat(deduct_cash_amount)).toFixed(2)));
}
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
 
 function showedit(e){
    var route_id = e.attr("data-var");
    var trans_date = e.attr("data-date");
    // alert(trans_date);
    $(".add-line-date").val(trans_date);
    $("#editModal").modal("show").find(".route-id").val(route_id);
 }
JS;
$this->registerJs($js, static::POS_END);
?>
