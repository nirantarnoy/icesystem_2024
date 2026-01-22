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

$is_admin = \backend\models\User::checkIsAdmin(\Yii::$app->user->id);

include \Yii::getAlias("@backend/helpers/ChangeAdminDate2.php");

$model_customer_loan = null;
if ($is_start_find == 1) {
    if ($find_customer_id != null) {
        if ($is_find_date == 1) {
            $model_customer_loan = \common\models\QuerySaleMobileDataNew::find()->select(['route_id'])->where(['>=', 'order_date', date('Y-m-d H:i', strtotime($from_date))])
                ->andFilterWhere(['<=','order_date',date('Y-m-d H:i', strtotime($to_date))])
                ->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])
                ->andFilterWhere(['IN', 'route_id', $find_customer_id])
                ->andFilterWhere(['>', 'line_total_credit', 0])
                ->distinct(['route_id'])->orderBy(['route_id' => SORT_ASC])->all();
        } else {
            $model_customer_loan = \common\models\QuerySaleMobileDataNew::find()->select(['route_id'])->where(['>=', 'order_date', date('Y-m-d H:i', strtotime($from_date))])
                ->andFilterWhere(['<=','order_date',date('Y-m-d H:i', strtotime($to_date))])
                ->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])
                ->andFilterWhere(['IN', 'route_id', $find_customer_id])
                ->andFilterWhere(['>', 'line_total_credit', 0])
                ->groupBy(['route_id'])->orderBy(['route_id' => SORT_ASC])->all();
        }


    } else { // not select route
        if ($is_find_date == 1) {
            $model_customer_loan = \common\models\QuerySaleMobileDataNew::find()->select(['route_id'])->where(['>=', 'order_date', date('Y-m-d H:i', strtotime($from_date))])
                ->andFilterWhere(['<=','order_date',date('Y-m-d H:i', strtotime($to_date))])
                ->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])
                ->andFilterWhere(['>', 'line_total_credit', 0])
                ->groupBy(['route_id'])->orderBy(['route_id' => SORT_ASC])->all();
        } else {
            $model_customer_loan = \common\models\QuerySaleMobileDataNew::find()->select(['route_id'])->where(['<=', 'order_date', date('Y-m-d H:i', strtotime($to_date))])
                ->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])
                ->andFilterWhere(['>', 'line_total_credit', 0])
                ->groupBy(['route_id'])->orderBy(['route_id' => SORT_ASC])->all();
        }
    }

    $user_login_datetime = '';
    $model_c_login = LoginLog::find()->select('MIN(login_date) as login_date')->where(['user_id' => $user_id, 'status' => 1])->one();
    if ($model_c_login != null) {
        $user_login_datetime = date('Y-m-d H:i:s', strtotime($model_c_login->login_date));
    } else {
        $user_login_datetime = date('Y-m-d H:i:s');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Summary By Route</title>
    <link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
    <style>
        #div1 {
            font-family: sarabun;
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
</head>
<body>

<form action="<?= \yii\helpers\Url::to(['paymentreceivecar/customerloanprintsummary'], true) ?>" method="post"
      id="form-search">
    <input type="hidden" name="is_start_find" value="1">
    <div id="div1">
        <table class="table-header" style="width: 100%;font-size: 18px;" border="0">
            <tr>
                <td>
                    <?php
                    $is_checked = "";
                    if ($is_find_date != null && $is_find_date != 0) {
                        $is_checked = "checked";
                    }
                    ?>
                    <input type="checkbox" value="<?= $is_find_date ?>" onchange="$(this).val(1)"
                           name="is_find_date" <?= $is_checked ?>> ค้นหาตามช่วงเวลา
                </td>
            </tr>
            <tr>
                <td style="width: 25%">
                    <label>ตั้งแต่วันที่</label>
                    <?php
                    echo DateRangePicker::widget([
                        'name' => 'from_date',
                        'value' => $from_date != null ? date('Y-m-d H:i', strtotime($from_date)) : date('Y-m-d H:i'),
                        'convertFormat' => true,
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'ตั้งแต่วันที่',
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
                <td style="width: 25%">
                    <label for="">ถึงวันที่</label>
                    <?php
                    echo DateRangePicker::widget([
                        'name' => 'to_date',
                        'value' => $to_date != null ? date('Y-m-d H:i', strtotime($to_date)) : date('Y-m-d H:i'),
                        'convertFormat' => true,
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'ถึงวันที่',
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
                    <label for="">สายส่ง</label>
                    <?php
                    echo \kartik\select2\Select2::widget([
                        'name' => 'find_customer_id',
                        'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1])->all(), 'id', 'name'),
                        'value' => $find_customer_id,
                        'options' => [
                            'placeholder' => '--สายส่ง--'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ]
                    ]);
                    ?>
                </td>
                <td style="width: 20%">
                    <label for="">ลูกค้า</label>
                    <?php
                    echo \kartik\select2\Select2::widget([
                        'name' => 'find_customer_id_select',
                        'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customer::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', 'name'),
                        'value' => $find_customer_id_select,
                        'options' => [
                            'placeholder' => '--ลูกค้า--'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ]
                    ]);
                    ?>
                </td>
                <td style="width: 20%">
                    <label for="">มี/ไม่มีรายละเอียด</label>
                    <select name="find_has_detail" class="form-control" id="">
                        <option value="0" <?= $find_has_detail == 0 ? 'selected' : '' ?>>ทั้งหมด</option>
                        <option value="1" <?= $find_has_detail == 1 ? 'selected' : '' ?>>มี</option>
                        <option value="2" <?= $find_has_detail == 2 ? 'selected' : '' ?>>ไม่มี</option>
                    </select>
                </td>
                <td>
                    <label for="" style="color: white">ค้นหา</label>
                    <input type="submit" class="btn btn-primary" style="margin-top: 0px;" value="ค้นหา">
                </td>
            </tr>
        </table>
</form>
<br/>
<table class="table-header" width="100%">
    <tr>
        <td style="text-align: center; font-size: 20px; font-weight: bold">รายงานสรุปยอดหนี้ลูกค้าขายเชื่อ(แยกตามสายส่งและเดือน)
        </td>
    </tr>
</table>
<br>
<table class="table-header" width="100%">
    <tr>
        <td style="text-align: center; font-size: 20px; font-weight: normal">
            ถึง <span style="color: red"><?= date('Y-m-d H:i', strtotime($to_date)) ?></span></td>
    </tr>
</table>
<br>
<table class="table-title" id="table-data" style="width: 100%">
    <tr>
        <td style="border: 1px solid gray;text-align: center"><b>ลำดับ</b></td>
        <td style="border: 1px solid gray;text-align: center"><b>สายส่ง</b></td>
        <td style="border: 1px solid gray;text-align: left"><b>ลูกค้า</b></td>
        <td style="border: 1px solid gray;text-align: center"><b>เดือน/ปี</b></td>
        <td style="text-align: right;border: 1px solid gray"><b>จำนวนเงิน</b></td>
        <td style="text-align: right;border: 1px solid gray"><b>ชำระแล้ว</b></td>
        <td style="text-align: right;border: 1px solid gray"><b>ค้างชำระ</b></td>
    </tr>
    <?php
    $sum_line_total_all = 0;
    $sum_line_pay_all = 0;
    $line_remain_all = 0;
    $line_nums = 0;
    ?>
    <?php if ($model_customer_loan != null): ?>
        <?php foreach ($model_customer_loan as $value): ?>
            <?php
            $line_route_name = \backend\models\Deliveryroute::findName($value->route_id);
            $monthly_data = getRouteMonthlySummary($value->route_id, $from_date, $to_date, $company_id, $branch_id, $is_find_date, $find_customer_id_select, $find_has_detail);
            $route_total_credit = 0;
            $route_total_pay = 0;
            ?>
            <?php if ($monthly_data != null): ?>
                <?php foreach ($monthly_data as $data): ?>
                    <?php
                    $line_nums += 1;
                    $sum_line_total_all += $data['total_credit'];
                    $sum_line_pay_all += $data['total_pay'];
                    $line_remain_all += ($data['total_credit'] - $data['total_pay']);

                    $route_total_credit += $data['total_credit'];
                    $route_total_pay += $data['total_pay'];
                    ?>
                    <tr>
                        <td style="font-size: 16px;border: 1px solid gray;text-align: center"><?= $line_nums ?> </td>
                        <td style="font-size: 16px;border: 1px solid gray;text-align: center"><?= $line_route_name ?> </td>
                        <td style="font-size: 16px;border: 1px solid gray;text-align: left"><?= $data['customer_name'] ?></td>
                        <td style="font-size: 16px;border: 1px solid gray;text-align: center"><?= $data['month_year'] ?></td>
                        <td style="font-size: 16px;text-align: right;border: 1px solid gray"><?= number_format($data['total_credit'], 2) ?></td>
                        <td style="font-size: 16px;text-align: right;color: green;border: 1px solid gray"><?= number_format($data['total_pay'], 2) ?></td>
                        <td style="font-size: 16px;text-align: right;color: red;border: 1px solid gray"><?= number_format(($data['total_credit'] - $data['total_pay']), 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr style="background-color: #36bd1bff">
                    <td colspan="4" style="font-size: 16px;border: 1px solid gray;text-align: right;"><b>รวมสายส่ง (<?= $line_route_name ?>)</b></td>
                    <td style="font-size: 16px;text-align: right;border: 1px solid gray"><b><?= number_format($route_total_credit, 2) ?></b></td>
                    <td style="font-size: 16px;text-align: right;border: 1px solid gray"><b><?= number_format($route_total_pay, 2) ?></b></td>
                    <td style="font-size: 16px;text-align: right;border: 1px solid gray"><b><?= number_format(($route_total_credit - $route_total_pay), 2) ?></b></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <tfoot>
    <tr>
        <td colspan="4" style="font-size: 18px;border-top: 1px solid black; text-align: right;"><b>รวมทั้งสิ้น</b></td>
        <td style="font-size: 18px;text-align: right;border-top: 1px solid black;border-bottom: 1px solid black">
            <b style="color: green"><?= number_format($sum_line_total_all, 2) ?></b></td>
        <td style="font-size: 16px;text-align: right;border-top: 1px solid black;border-bottom: 1px solid black">
            <b><?= number_format($sum_line_pay_all, 2) ?></b></td>
        <td style="font-size: 18px;text-align: right;border-top: 1px solid black;border-bottom: 1px solid black">
            <b style="color: red"><?= number_format($line_remain_all, 2) ?></b></td>
    </tr>
    </tfoot>
</table>

</div>
<br/>
<table width="100%" class="table-title">
    <tr>
        <td>
            <a class="btn btn-info" href="<?= \yii\helpers\Url::to(['paymentreceivecar/carsummaryupdate'], true) ?>">อัพเดทใบส่งของ</a>
        </td>
        <td style="text-align: right">
            <a href="<?= \yii\helpers\Url::to(['paymentreceivecar/customerloanprint'], true) ?>" class="btn btn-success">ดูรายละเอียด</a>
            <button id="btn-export-excel" class="btn btn-secondary">Export Excel</button>
            <button id="btn-print" class="btn btn-warning" onclick="printContent('div1')">Print</button>
        </td>
    </tr>
</table>
</body>
</html>

<?php
function getRouteMonthlySummary($route_id, $f_date, $t_date, $company_id, $branch_id, $is_find_date, $find_customer_id_select, $find_has_detail)
{
    $data = [];
    if ($route_id != null) {
        if ($is_find_date == 0 || $is_find_date == null) {
            $sql = "SELECT 
                        t2.customer_id, 
                        t3.name as customer_name, 
                        t3.description as customer_detail,
                        MONTH(t2.order_date) as m, 
                        YEAR(t2.order_date) as y, 
                        sum(t2.line_total_credit) as total_credit
                  FROM query_sale_mobile_data_new2 as t2
                  LEFT JOIN customer as t3 ON t2.customer_id = t3.id
                  WHERE  t2.order_date <= :t_date
                  AND t2.route_id = :route_id              
                  AND t2.payment_method_id = 2
                  AND t2.payment_status = 0
                  AND t2.sale_from_mobile = 1
                  AND t2.company_id = :company_id AND t2.branch_id = :branch_id";
             
             $params = [
                 ':t_date' => date('Y-m-d H:i:s', strtotime($t_date)),
                 ':route_id' => $route_id,
                 ':company_id' => $company_id,
                 ':branch_id' => $branch_id,
             ];
             
             if ($find_customer_id_select != null && count($find_customer_id_select) > 0) {
                 $sql .= " AND t2.customer_id IN (" . implode(',', array_map('intval', $find_customer_id_select)) . ")";
             }
             
             $sql .= " GROUP BY t2.customer_id, YEAR(t2.order_date), MONTH(t2.order_date)";
             $sql .= " ORDER BY t2.customer_id ASC, YEAR(t2.order_date) ASC, MONTH(t2.order_date) ASC";
        } else {
            $sql = "SELECT 
                        (CASE WHEN t1.customer_id > 0 THEN t1.customer_id ELSE t2.customer_id END) as customer_id, 
                        IFNULL(t3.name, t2.customer_name) as customer_name, 
                        t3.description as customer_detail,
                        MONTH(t2.order_date) as m, 
                        YEAR(t2.order_date) as y, 
                        sum(t1.price * t1.qty) as total_credit
                 FROM order_line as t1 
                 inner join orders as t2 on t1.order_id = t2.id
                 left join customer as t3 on (CASE WHEN t1.customer_id > 0 THEN t1.customer_id ELSE t2.customer_id END) = t3.id
                 WHERE  t2.order_date >= :f_date
                 AND t2.order_date <= :t_date
                 AND t2.order_channel_id = :route_id
                 AND t2.payment_method_id = 2
                 AND t1.line_total > 0
                 AND t2.payment_status = 0
                 AND t2.sale_from_mobile = 1
                 AND t1.status in(1,100)
                 AND t2.company_id = :company_id AND t2.branch_id = :branch_id";
             
             $params = [
                 ':f_date' => date('Y-m-d H:i:s', strtotime($f_date)),
                 ':t_date' => date('Y-m-d H:i:s', strtotime($t_date)),
                 ':route_id' => $route_id,
                 ':company_id' => $company_id,
                 ':branch_id' => $branch_id,
             ];

             if ($find_customer_id_select != null && count($find_customer_id_select) > 0) {
                 $sql .= " AND (CASE WHEN t1.customer_id > 0 THEN t1.customer_id ELSE t2.customer_id END) IN (" . implode(',', array_map('intval', $find_customer_id_select)) . ")";
             }

             $sql .= " GROUP BY (CASE WHEN t1.customer_id > 0 THEN t1.customer_id ELSE t2.customer_id END), YEAR(t2.order_date), MONTH(t2.order_date)";
             $sql .= " ORDER BY (CASE WHEN t1.customer_id > 0 THEN t1.customer_id ELSE t2.customer_id END) ASC, YEAR(t2.order_date) ASC, MONTH(t2.order_date) ASC";
        }

        $query = \Yii::$app->db->createCommand($sql);
        foreach ($params as $key => $val) {
            $query->bindValue($key, $val);
        }
        $model = $query->queryAll();
        if ($model) {
            foreach ($model as $row) {
                if ($find_has_detail == 1) {
                    if ($row['customer_detail'] == '' || $row['customer_detail'] == null) continue;
                }
                if ($find_has_detail == 2) {
                    if ($row['customer_detail'] != '' && $row['customer_detail'] != null) continue;
                }

                // Get paid amount for this route, customer and month
                $paid = getRouteMonthlyPaid($route_id, $row['customer_id'], $row['m'], $row['y'], $company_id, $branch_id, $is_find_date, $f_date, $t_date);
               // $paid = getPaytrans($row['order_id'], $row['customer_id']);
                array_push($data, [
                    'customer_id' => $row['customer_id'],
                    'customer_name' => $row['customer_name'] != '' ? $row['customer_name'] : \backend\models\Customer::findName($row['customer_id']),
                    'month_year' => $row['m'] . '/' . $row['y'],
                    'total_credit' => $row['total_credit'],
                    'total_pay' => $paid,
                ]);
            }
        }
    }
    return $data;
}
function getPaytrans($order_id, $customer_id)
{
    $pay_total = 0;
    if ($order_id && $customer_id) {
        $model = \common\models\QueryPaymentReceive::find()->where(['order_id' => $order_id, 'customer_id' => $customer_id])->sum('payment_amount');
        $pay_total = $model;
    }
    return $pay_total;
}
function getRouteMonthlyPaid($route_id, $customer_id, $m, $y, $company_id, $branch_id, $is_find_date = 0, $f_date = null, $t_date = null)
{
    if (!$customer_id) return 0;
    
    $sql = "SELECT sum(t3.payment_amount) as paid
            FROM orders as t2 
            INNER JOIN query_payment_receive as t3 ON t2.id = t3.order_id
            WHERE t2.order_channel_id = :route_id
            AND t3.customer_id = :customer_id
            AND t2.payment_method_id = 2
            AND t2.sale_from_mobile = 1
            AND t3.payment_status = 0
            AND MONTH(t2.order_date) = :m
            AND YEAR(t2.order_date) = :y
            AND t2.company_id = :company_id
            AND t2.branch_id = :branch_id";
            
    $params = [
        ':route_id' => $route_id,
        ':customer_id' => $customer_id,
        ':m' => $m,
        ':y' => $y,
        ':company_id' => $company_id,
        ':branch_id' => $branch_id,
    ];

    $query = \Yii::$app->db->createCommand($sql);
    foreach ($params as $key => $val) {
        $query->bindValue($key, $val);
    }
    
    $res = $query->queryOne();
    return $res['paid'] ?? 0;
}

?>

<?php
$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/jquery.table2excel.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$js = <<<JS
 $(function(){
    $("#btn-export-excel").click(function(){
          $("#table-data").table2excel({
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
