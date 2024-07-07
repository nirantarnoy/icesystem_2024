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
//$model_customer_loan = \common\models\QueryProductTransDaily::find()->where(['date(trans_date)' => date('Y-m-d')])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])->all();
$model_order_mobile = \common\models\Orders::find()->where(['BETWEEN', 'order_date', date('Y-m-d H:i', strtotime($from_date)), date('Y-m-d H:i', strtotime($to_date))])
    ->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])
    ->andFilterWhere(['sale_from_mobile' => 1])
    ->andFilterWhere(['OR',['emp_1' => $find_emp_id],['emp_2' => $find_emp_id]])
    ->groupBy('order_channel_id')->orderBy(['order_channel_id' => SORT_ASC])->all();
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
            font-size: 18px;
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

<form action="<?= \yii\helpers\Url::to(['salecomreport/index'], true) ?>" method="post" id="form-search">
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

            <td>
                <?php
                echo \kartik\select2\Select2::widget([
                    'name' => 'find_emp_id',
                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\Employee::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', 'fname'),
                    'value' => $find_emp_id,
                    'options' => [
                        'placeholder' => '--พนักงาน--'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'multiple' => true,
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
            <td style="text-align: center; font-size: 20px; font-weight: bold">รายงานค่าคอมมิชชั่น</td>
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
    <table class="table-header" width="100%">
    </table>
    <table class="table-title" id="table-data" style="width: 100%">
        <tr>
            <td rowspan="2"
                style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;border-left: 1px solid gray">
                <b>สายส่ง</b></td>
            <td rowspan="2"
                style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b>ทะเบียนรถ</b></td>
            <td colspan="2"
                style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b>คนขับ</b></td>
            <td rowspan="2"
                style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b>จำนวน</b></td>
            <td rowspan="2"
                style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b>ราคารวม</b></td>
            <td colspan="3"
                style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b>ค่าคอม</b></td>
        </tr>
        <tr>
            <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b>คนที่1</b></td>
            <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b>คนที่2</b></td>
            <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b>ค่าคอม</b></td>
            <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b>พิเศษ</b></td>
            <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b>รวม</b></td>
        </tr>
        <?php
        $total_qty_all = 0;
        $total_amt_all = 0;
        $total_com_all = 0;
        $total_special_all = 0;
        $total_com_sum_all = 0;

        ?>
        <?php foreach ($model_order_mobile as $value): ?>
            <?php
            $com_rate = 0;
            $route_emp_count = 0;
            ?>
            <?php
            $route_total = null;
            $route_name = \backend\models\Deliveryroute::findName($value->order_channel_id);

            $route_total = getRouteSumAll($value->order_channel_id, $from_date, $to_date, $company_id, $branch_id, substr($route_name, 0, 2), $find_emp_id[0]);
//            if (substr($route_name, 0, 2) == 'CJ') {
//
//            }

            ?>
            <tr>
                <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;border-left: 1px solid gray"><?= $route_name ?></td>
                <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?= \backend\models\Car::findName($value->car_ref_id) ?></td>
<!--                <td style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"></td>-->
<!--                <td style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"></td>-->
                <td colspan="7" style="border-right: 1px solid gray"></td>
<!--                <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">--><?//= number_format($route_total[0]['total_qty'], 2) ?><!--</td>-->
<!--                <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">--><?//= number_format($route_total[0]['total_amt'], 2) ?><!--</td>-->
<!--                <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">--><?//= number_format(0, 2) ?><!--</td>-->
<!--                <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">--><?//= number_format(0, 2) ?><!--</td>-->
<!--                <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">--><?//= number_format(0, 2) ?><!--</td>-->
            </tr>
            <?php

            $order_date = getOrder($value->order_channel_id, $from_date, $to_date, $company_id, $branch_id, $find_emp_id[0]);

            $group_total_qty = 0;
            $group_total_amt = 0;
            $group_total_com = 0;
            $group_total_spacial = 0;
            $group_total_all = 0 ;

            for ($m = 0; $m <= count($order_date) - 1; $m++):
                ?>
                <?php

                $order_data = null;
                if (substr($route_name, 0, 2) == 'CJ') {
                    $order_data = getOrderlineCJ($value->order_channel_id, $order_date[$m]['order_date'], $company_id, $branch_id, $find_emp_id[0]);
                } else {
                    $order_data = getOrderline($value->order_channel_id, $order_date[$m]['order_date'], $company_id, $branch_id, $find_emp_id[0]);
                }

                if($order_data == null)continue;

                $route_emp_count = 0;
                $com_rate = 0;
                if ((double)$order_data[0]['emp_1'] > 0) {
                    $route_emp_count += 1;
                }
                if ((double)$order_data[0]['emp_2'] > 0) {
                    $route_emp_count += 1;
                }
                $com_rate = getComRate($route_emp_count, $company_id, $branch_id);

                $group_total_qty = $group_total_qty + (double)$order_data[0]['total_qty'];
                $group_total_amt = $group_total_amt + (double)$order_data[0]['total_amt'];

                $total_qty_all = $total_qty_all + (double)$order_data[0]['total_qty'];
                $total_amt_all = $total_amt_all + (double)$order_data[0]['total_amt'];

                $line_com = 0;

                if(substr($route_name, 0, 2) == 'CJ'){
                    if($route_emp_count == 1){
                        $line_com = (($order_data[0]['total_qty'] * $com_rate) * 2);
                    }else{
                        $line_com = $order_data[0]['total_qty'] * $com_rate;
                    }

                }else{
                    $line_com = $order_data[0]['total_qty'] * $com_rate;
                }

                $line_special = $order_data[0]['total_amt'] >= 3500 && $route_emp_count == 1 ? 30 : 0;
                $line_com_total = $line_com;


                $group_total_com = $group_total_com + $line_com;
                $group_total_spacial = $group_total_spacial + $line_special;

                $group_total_all = $group_total_all + ($line_com + $line_special);

                $total_com_all = $total_com_all + $line_com_total;
                $total_special_all = $total_special_all + $line_special;
                $total_com_sum_all = $total_com_sum_all + ($line_com + $line_special);
                ?>
                <tr style="background-color: #d0e9c6">
                    <td colspan="2"
                        style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;border-left: 1px solid gray;text-indent: 50px;">
                        <span> </span> <?= $order_date[$m]['order_date'] ?></td>
                    <td style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?= \backend\models\Employee::findName2($order_data[0]['emp_1']) ?></td>
                    <td style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?= \backend\models\Employee::findName2($order_data[0]['emp_2']) ?></td>
                    <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?= number_format($order_data[0]['total_qty'], 2) ?></td>
                    <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?= number_format($order_data[0]['total_amt'], 2) ?></td>
                    <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?= number_format($line_com, 2) ?></td>
                    <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?= number_format($line_special) ?></td>
                    <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?= number_format(($line_com + $line_special), 2) ?></td>
                </tr>
            <?php endfor; ?>
            <tr style="background-color: #d0e9c6">
                  <td colspan="2" style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-left: 1px solid gray"></td>
                  <td style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 0px solid gray"></td>
                  <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b>รวม</b></td>
                  <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b><?= number_format($group_total_qty, 2) ?></b></td>
                  <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b><?= number_format($group_total_amt, 2) ?></b></td>
                  <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b><?= number_format($group_total_com, 2) ?></b></td>
                  <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b><?= number_format($group_total_spacial, 0) ?></b></td>
                  <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b><?= number_format($group_total_all, 2) ?></b></td>
              </tr>
        <?php endforeach; ?>
        <tfoot>
        <tr>
            <td colspan="4"
                style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;border-left: 1px solid gray">
                <b>รวมทั้งหมด</b></td>
            <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b><?= number_format($total_qty_all, 2) ?></b></td>
            <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b><?= number_format($total_amt_all, 2) ?></b></td>
            <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b><?= number_format($total_com_all, 2) ?></b></td>
            <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b><?= number_format($total_special_all) ?></b></td>
            <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b><?= number_format($total_com_sum_all, 2) ?></b></td>
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
//function getDriver($order_id){
//    $name = '';
//    if($order_id){
//        $model = \backend\models\Orders::find(['id'=>])->where()->one();
//    }
//    return $name;
//}
function getOrder($route_id, $f_date, $t_date, $company_id, $branch_id, $find_emp_id)
{

    $data = [];
    if ($route_id != null) {
        $sql = "SELECT date(t2.order_date) as order_date
              FROM orders as t2 INNER  JOIN order_line as t3 ON t3.order_id = t2.id
             WHERE  t2.order_date >=" . "'" . date('Y-m-d H:i:s', strtotime($f_date)) . "'" . " 
             AND t2.order_date <=" . "'" . date('Y-m-d H:i:s', strtotime($t_date)) . "'" . " 
             AND t2.order_channel_id =" . $route_id . " 
             AND (t2.emp_1 =" . $find_emp_id . " 
              OR t2.emp_2 =".$find_emp_id.") 
             AND t2.company_id=" . $company_id . " AND t2.branch_id=" . $branch_id;

        $sql .= " GROUP BY date(t2.order_date)";
        $sql .= " ORDER BY date(t2.order_date) ASC";
        $query = \Yii::$app->db->createCommand($sql);
        $model = $query->queryAll();
        if ($model) {
            for ($i = 0; $i <= count($model) - 1; $i++) {

                array_push($data, [
                    //   'order_no' => $model[$i]['order_no'],
                    'order_date' => $model[$i]['order_date'],
                ]);
            }
        }
    }

    return $data;
}

//function getOrderline($route_id, $f_date, $company_id, $branch_id)
//{
//
//    $data = [];
//    if ($route_id != null) {
//        $sql = "SELECT date(t2.order_date2) as order_date, SUM(t3.qty) as total_qty, SUM(t3.line_total) as total_amt, t2.emp_1,t2.emp_2
//              FROM orders as t2 INNER  JOIN order_line as t3 ON t3.order_id = t2.id
//             WHERE  date(t2.order_date2) = " . "'" . date('Y-m-d', strtotime($f_date)) . "'" . "
//             AND t2.order_channel_id =" . $route_id . "
//             AND t3.qty > 0
//             AND t2.company_id=" . $company_id . " AND t2.branch_id=" . $branch_id;
//
//        $sql .= " GROUP BY date(t2.order_date)";
//        $sql .= " ORDER BY date(t2.order_date) ASC";
//        $query = \Yii::$app->db->createCommand($sql);
//        $model = $query->queryAll();
//        if ($model) {
//            for ($i = 0; $i <= count($model) - 1; $i++) {
//                array_push($data, [
//                    //   'order_no' => $model[$i]['order_no'],
//                    'order_date' => $model[$i]['order_date'],
//                    'total_qty' => $model[$i]['total_qty'],
//                    'total_amt' => $model[$i]['total_amt'],
//                    'emp_1' => $model[$i]['emp_1'],
//                    'emp_2' => $model[$i]['emp_2'],
//                ]);
//            }
//        }
//    }
//
//    return $data;
//}
function getOrderline($route_id, $f_date, $company_id, $branch_id,$emp_id)
{

    $data = [];
    if ($route_id != null) {
        $sql = "SELECT date(t2.order_date) as order_date, SUM((t2.line_qty_cash + t2.line_qty_credit)/t4.nw) as total_qty, SUM(t2.line_total) as total_amt, t3.emp_1,t3.emp_2
              FROM query_sale_mobile_data_new as t2 INNER  JOIN  orders as t3 ON t2.id = t3.id INNER JOIN product as t4 ON t2.product_id = t4.id
             WHERE  date(t2.order_date) = " . "'" . date('Y-m-d', strtotime($f_date)) . "'" . " 
             AND t2.route_id =" . $route_id . " 
              AND (t3.emp_1 =" . $emp_id . " 
              OR t3.emp_2 =".$emp_id.") 
             AND t2.qty > 0  
              AND t2.company_id=" . $company_id . " AND t2.branch_id=" . $branch_id;

        $sql .= " GROUP BY date(t2.order_date)";
        $sql .= " ORDER BY date(t2.order_date) ASC";
        $query = \Yii::$app->db->createCommand($sql);
        $model = $query->queryAll();
        if ($model) {
            for ($i = 0; $i <= count($model) - 1; $i++) {
                array_push($data, [
                    //   'order_no' => $model[$i]['order_no'],
                    'order_date' => $model[$i]['order_date'],
                    'total_qty' => $model[$i]['total_qty'],
                    'total_amt' => $model[$i]['total_amt'],
                    'emp_1' => $model[$i]['emp_1'],
                    'emp_2' => $model[$i]['emp_2'],
                ]);
            }
        }
    }

    return $data;
}


function getOrderCJ($route_id, $f_date, $t_date, $company_id, $branch_id)
{

    $data = [];
    if ($route_id != null) {
        $sql = "SELECT date(t2.order_date) as order_date, SUM(t3.qty / t4.nw) as total_qty, SUM(t3.line_total) as total_amt 
              FROM orders as t2 INNER  JOIN order_line as t3 ON t3.order_id = t2.id INNER JOIN product as t4 ON t3.product_id = t4.id
             WHERE  t2.order_date >=" . "'" . date('Y-m-d H:i:s', strtotime($f_date)) . "'" . " 
             AND t2.order_date <=" . "'" . date('Y-m-d H:i:s', strtotime($t_date)) . "'" . " 
             AND t2.order_channel_id =" . $route_id . " 
             AND t2.company_id=" . $company_id . " AND t2.branch_id=" . $branch_id;

        $sql .= " GROUP BY date(t2.order_date)";
        $sql .= " ORDER BY date(t2.order_date) ASC";
        $query = \Yii::$app->db->createCommand($sql);
        $model = $query->queryAll();
        if ($model) {
            for ($i = 0; $i <= count($model) - 1; $i++) {

                array_push($data, [
                    //   'order_no' => $model[$i]['order_no'],
                    'order_date' => $model[$i]['order_date'],
                    'total_qty' => $model[$i]['total_qty'],
                    'total_amt' => $model[$i]['total_amt'],

                ]);
            }
        }
    }

    return $data;
}

function getOrderlineCJ($route_id, $f_date, $company_id, $branch_id, $emp_id)
{

    $data = [];
    if ($route_id != null) {
        $sql = "SELECT date(t2.order_date) as order_date, SUM(t3.qty / t4.nw) as total_qty, SUM(t3.line_total) as total_amt , t2.emp_1,t2.emp_2
              FROM orders as t2 INNER  JOIN order_line as t3 ON t3.order_id = t2.id INNER JOIN product as t4 ON t3.product_id = t4.id
             WHERE  date(t2.order_date) =" . "'" . date('Y-m-d', strtotime($f_date)) . "'" . " 
             AND t2.order_channel_id =" . $route_id . " 
              AND (t2.emp_1 =" . $emp_id . " 
              OR t2.emp_2 =".$emp_id.") 
             AND t2.company_id=" . $company_id . " AND t2.branch_id=" . $branch_id;

        $sql .= " GROUP BY date(t2.order_date)";
        $sql .= " ORDER BY date(t2.order_date) ASC";
        $query = \Yii::$app->db->createCommand($sql);
        $model = $query->queryAll();
        if ($model) {
            for ($i = 0; $i <= count($model) - 1; $i++) {

                array_push($data, [
                    //   'order_no' => $model[$i]['order_no'],
                    'order_date' => $model[$i]['order_date'],
                    'total_qty' => $model[$i]['total_qty'],
                    'total_amt' => $model[$i]['total_amt'],
                    'emp_1' => $model[$i]['emp_1'],
                    'emp_2' => $model[$i]['emp_2'],
                ]);
            }
        }
    }

    return $data;
}

function getRouteSum($route_id, $f_date, $t_date, $company_id, $branch_id)
{

    $data = [];
    if ($route_id != null) {
//        $sql = "SELECT t2.order_no, SUM(t3.qty) as total_qty, SUM(t3.line_total) as total_amt
//              FROM orders as t2 INNER  JOIN order_line as t3 ON t3.order_id = t2.id
//             WHERE  t2.order_date >=" . "'" . date('Y-m-d H:i:s', strtotime($f_date)) . "'" . "
//             AND t2.order_date <=" . "'" . date('Y-m-d H:i:s', strtotime($t_date)) . "'" . "
//             AND t2.order_channel_id =" . $route_id . "
//             AND t2.company_id=" . $company_id . " AND t2.branch_id=" . $branch_id;

        $sql = "SELECT t2.order_no, SUM(t3.qty) as total_qty, SUM(t3.line_total) as total_amt
              FROM orders as t2 INNER  JOIN order_line as t3 ON t3.order_id = t2.id
             WHERE  (t2.order_date BETWEEN " . "'" . date('Y-m-d H:i:s', strtotime($f_date)) . "'" . "
             AND " . "'" . date('Y-m-d H:i:s', strtotime($t_date)) . "')" . "
             AND t2.order_channel_id =" . $route_id . "
             AND t2.company_id=" . $company_id . " AND t2.branch_id=" . $branch_id;

        $sql .= " GROUP BY t2.order_channel_id";
        $query = \Yii::$app->db->createCommand($sql);
        $model = $query->queryAll();
        if ($model) {
            for ($i = 0; $i <= count($model) - 1; $i++) {

                array_push($data, [
                    'total_qty' => $model[$i]['total_qty'],
                    'total_amt' => $model[$i]['total_amt'],
                ]);
            }
        }
    }

    return $data;
}

//function getRouteSum($route_id, $f_date, $t_date, $company_id, $branch_id)
//{
//
//    $data = [];
//    if ($route_id != null) {
//        $sql = "SUM(qty) as total_qty,SUM(line_total) as total_amt
//            FROM query_sale_mobile_data_new WHERE  order_date >=" . "'" . date('Y-m-d H:i:s', strtotime($f_date)) . "'" . "
//             AND order_date <=" . "'" . date('Y-m-d H:i:s', strtotime($t_date)) . "'" . "
//             AND route_id =" . $route_id . "
//             AND company_id=" . $company_id . " AND branch_id=" . $branch_id;
//
//        $sql .= " GROUP BY route_id";
//        $query = \Yii::$app->db->createCommand($sql);
//        $model = $query->queryAll();
//        if ($model) {
//            for ($i = 0; $i <= count($model) - 1; $i++) {
//
//                array_push($data, [
//                    'total_qty' => $model[$i]['total_qty'],
//                    'total_amt' => $model[$i]['total_amt'],
//                ]);
//            }
//        }
//    }
//
//    return $data;
//}

function getRouteSumCJ($route_id, $f_date, $t_date, $company_id, $branch_id)
{

    $data = [];
    if ($route_id != null) {
        $sql = "SELECT t2.order_no, SUM(t3.qty / t4.nw) as total_qty, SUM(t3.line_total) as total_amt 
              FROM orders as t2 INNER  JOIN order_line as t3 ON t3.order_id = t2.id INNER JOIN product as t4 ON t3.product_id = t4.id
             WHERE  t2.order_date >=" . "'" . date('Y-m-d H:i:s', strtotime($f_date)) . "'" . " 
             AND t2.order_date <=" . "'" . date('Y-m-d H:i:s', strtotime($t_date)) . "'" . " 
             AND t2.order_channel_id =" . $route_id . " 
             AND t2.company_id=" . $company_id . " AND t2.branch_id=" . $branch_id;

        $sql .= " GROUP BY t2.order_channel_id";
        $query = \Yii::$app->db->createCommand($sql);
        $model = $query->queryAll();
        if ($model) {

            for ($i = 0; $i <= count($model) - 1; $i++) {

                array_push($data, [
                    'total_qty' => $model[$i]['total_qty'],
                    'total_amt' => $model[$i]['total_amt'],
                ]);
            }
        }
    }

    return $data;
}

function getComRate($count, $company_id, $branch_id)
{
    $rate = 0;
    $model = \backend\models\Salecom::find()->where(['emp_qty' => $count, 'company_id' => $company_id, 'branch_id' => $branch_id])->one();
    if ($model) {
        $rate = $model->com_extra;
    }
    return $rate;
}


function getRouteSumAll($route_id, $f_date, $t_date, $company_id, $branch_id, $route_name, $find_emp_id)
{

    $data = [];
    $sql = '';
    if ($route_id != null) {
        if ($route_name == 'CJ') {
            $sql = "SELECT  SUM(t3.qty / t4.nw) as total_qty, SUM(t3.line_total) as total_amt 
              FROM orders as t2 INNER  JOIN order_line as t3 ON t3.order_id = t2.id INNER JOIN product as t4 ON t3.product_id = t4.id
             WHERE  date(t2.order_date) >=" . "'" . date('Y-m-d', strtotime($f_date)) . "'" . " 
             AND date(t2.order_date) <=" . "'" . date('Y-m-d', strtotime($t_date)) . "'" . " 
             AND t2.order_channel_id =".$route_id."
            AND (t2.emp_1 =" . $find_emp_id . " 
              OR t2.emp_2 =".$find_emp_id.") 
             AND t2.company_id=" . $company_id . " AND t2.branch_id=" . $branch_id;

            $sql .= " GROUP BY t2.order_channel_id";
        } else {
            $sql = "SELECT SUM(t3.qty) as total_qty, SUM(t3.line_total) as total_amt
              FROM orders as t2 INNER  JOIN order_line as t3 ON t3.order_id = t2.id
             WHERE  (t2.order_date BETWEEN " . "'" . date('Y-m-d', strtotime($f_date)) . "'" . "
             AND " . "'" . date('Y-m-d', strtotime($t_date)) . "')" . "
             AND t2.order_channel_id =" . $route_id . "
              AND (t2.emp_1 =" . $find_emp_id . " 
              OR t2.emp_2 =".$find_emp_id.") 
             AND t2.company_id=" . $company_id . " AND t2.branch_id=" . $branch_id;

            $sql .= " GROUP BY t2.order_channel_id";
        }

        $query = \Yii::$app->db->createCommand($sql);
        $model = $query->queryAll();
        if ($model) {
            for ($i = 0; $i <= count($model) - 1; $i++) {
                array_push($data, [
                    'total_qty' => $model[$i]['total_qty'],
                    'total_amt' => $model[$i]['total_amt'],
                ]);
            }
        }
    }

    return $data;
}

function getRouteComSum($route_id, $from_date, $to_date, $company_id, $branch_id, $com_rate, $route_emp_count)
{
    $data = [];
    $total_com_sum_all = 0;
    $total_special_all = 0;
    $order_data = getOrderline($route_id, $from_date, $company_id, $branch_id);
    for ($m = 0; $m <= count($order_data) - 1; $m++) {
        $line_special = $order_data[$m]['total_amt'] >= 3500 && $route_emp_count == 1 ? 30 : 0;
        $total_special_all = $total_special_all + $line_special;
    }
    array_push($data, ['special' => $total_special_all]);
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
function printContent(el)
      {
         var restorepage = document.body.innerHTML;
         var printcontent = document.getElementById(el).innerHTML;
         document.body.innerHTML = printcontent;
         window.print();
         document.body.innerHTML = restorepage;
     }
JS;
$this->registerJs($js, static::POS_END);
?>
