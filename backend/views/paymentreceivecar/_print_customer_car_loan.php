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
$model_customer_loan = \common\models\QuerySaleMobileDataNew::find()->where(['BETWEEN', 'order_date', date('Y-m-d H:i', strtotime($from_date)), date('Y-m-d H:i', strtotime($to_date))])
    ->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])
    ->andFilterWhere(['IN', 'route_id', $find_customer_id])
    ->andFilterWhere(['>', 'line_total_credit', 0])
    ->groupBy('route_id')->orderBy(['route_id' => SORT_ASC])->all();

$user_login_datetime = '';
$model_c_login = LoginLog::find()->select('MIN(login_date) as login_date')->where(['user_id' => $user_id, 'status' => 1])->one();
if ($model_c_login != null) {
    $user_login_datetime = date('Y-m-d H:i:s', strtotime($model_c_login->login_date));
} else {
    $user_login_datetime = date('Y-m-d H:i:s');
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

<form action="<?= \yii\helpers\Url::to(['paymentreceivecar/customerloanprint'], true) ?>" method="post"
      id="form-search">
    <div id="div1">
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
                        'name' => 'find_customer_id',
                        'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', 'name'),
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
                <td>
                    <input type="submit" class="btn btn-primary" value="ค้นหา">
                </td>
                <td style="width: 25%"></td>
            </tr>
        </table>
</form>
<br/>
<table class="table-header" width="100%">
    <tr>
        <td style="text-align: center; font-size: 20px; font-weight: bold">รายงานสรุปยอดหนี้ลูกค้าขายเชื่อ(แยกสายส่ง)
        </td>
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
        <td style="border-top: 1px dotted gray;border-bottom: 1px dotted gray"><b>เลขเอกสาร</b></td>
        <td style="border-top: 1px dotted gray;border-bottom: 1px dotted gray"><b>วันที่</b></td>
        <td style="border-top: 1px dotted gray;border-bottom: 1px dotted gray"><b>ลูกค้า</b></td>
        <td style="text-align: right;border-top: 1px dotted gray;border-bottom: 1px dotted gray"><b>จำนวนเงิน</b></td>
        <td style="text-align: right;border-top: 1px dotted gray;border-bottom: 1px dotted gray"><b>ชำระแล้ว</b></td>
        <td style="text-align: right;border-top: 1px dotted gray;border-bottom: 1px dotted gray"><b>ค้างชำระ</b></td>
        <td style="text-align: right;border-top: 1px dotted gray;border-bottom: 1px dotted gray"></td>
    </tr>
    <?php
    $sum_line_total_all = 0;
    $sum_line_pay_all = 0;
    $line_remain_all = 0;
    ?>
    <?php foreach ($model_customer_loan as $value): ?>
        <?php
        $line_route_code = \backend\models\Deliveryroute::findCode($value->route_id);
        $line_route_name = \backend\models\Deliveryroute::findName($value->route_id);
        ?>

        <tr data-var=""  style="background-color: #5bc0de">
            <td colspan="7"><b><?= $line_route_code ?></b> <span
                        style="color: darkblue"> <?= $line_route_name ?></span></td>
        </tr>
        <?php $find_order = getOrder($value->route_id, $from_date, $to_date, $company_id, $branch_id); ?>
        <?php if ($find_order != null): ?>
            <?php
            $loop_count = count($find_order);
            $x = 0;
            $sum_line_total = 0;
            $sum_line_pay = 0;
            $line_remain = 0;

            ?>
            <?php for ($i = 0; $i <= count($find_order) - 1; $i++): ?>
                <?php
                $x += 1;
                $sum_line_total += $find_order[$i]['total_credit'];
                $sum_line_pay += $find_order[$i]['total_pay'];
                $line_remain = $sum_line_total - $sum_line_pay;
//
                $sum_line_total_all += $find_order[$i]['total_credit'];
                $sum_line_pay_all += $find_order[$i]['total_pay'];
                $line_remain_all += ($find_order[$i]['total_credit'] - $find_order[$i]['total_pay']);
                ?>
                <tr>
                    <td style="font-size: 16px;"><?= $find_order[$i]['order_no'] ?> </td>
                    <td style="font-size: 16px;"><?= date('Y-m-d H:i:s', strtotime($find_order[$i]['order_date'])) ?></td>
                    <td style="font-size: 16px;"><?= $find_order[$i]['customer_name'] ?></td>
                    <td style="font-size: 16px;text-align: right;"><?= number_format($find_order[$i]['total_credit'], 2) ?></td>
                    <td style="font-size: 16px;text-align: right;color: green"><?= number_format($find_order[$i]['total_pay'], 2) ?></td>
                    <td style="font-size: 16px;text-align: right;color: red"><?= number_format(($find_order[$i]['total_credit'] - $find_order[$i]['total_pay']), 2) ?></td>
                    <td style="text-align: center;font-size: 16px;text-align: right">
                        <?php if($find_order[$i]['total_pay'] > 0):?>
                        <span class="btn btn-success btn-sm btn-show-more"><i class="fa fa-plus-circle"></i> </span>
                        <?php endif;?>
                        </td>
                </tr>
                <tr>
                    <td colspan="6" style="padding: 1px;">
                        <table class="table-detail" style="width: 100%;background-color: lightgrey;font-size: 14px;">
                            <tr>
                                <td style="text-align: center">#</td>
                                <td>เลขที่</td>
                                <td>วันที่ชำระ</td>
                                <td>จำนวน</td>
                                <td>ผู้รับชำระ</td>
                            </tr>
                            <?php
                            $pay_detail = getPayline($find_order[$i]['order_id'], $find_order[$i]['customer_id']);
                            ?>
                            <?php $nums = 0; ?>
                            <?php
                            for ($x = 0; $x <= count($pay_detail) - 1; $x++):
                                ?>
                                <?php $nums += 1; ?>
                                <tr>
                                    <td style="color: blue;text-align: center"><?= $nums ?></td>
                                    <td style="color: blue"><?= $pay_detail[$x]['journal_no'] ?></td>
                                    <td style="color: blue"><?= $pay_detail[$x]['journal_date'] ?></td>
                                    <td style="color: blue"><?= $pay_detail[$x]['total_pay'] ?></td>
                                    <td style="color: blue"></td>
                                </tr>
                            <?php endfor; ?>
                        </table>
                    </td>
                </tr>
                <?php if ($loop_count == $x): ?>
                    <tr>
                        <td style="font-size: 16px;border-top: 1px solid black"></td>
                        <td style="font-size: 16px;border-top: 1px solid black"></td>
                        <td style="font-size: 16px;text-align: right;border-top: 1px solid black;border-bottom: 1px solid black">
                            <b><?= number_format($sum_line_total, 2) ?></b></td>
                        <td style="font-size: 16px;text-align: right;border-top: 1px solid black;border-bottom: 1px solid black">
                            <b><?= number_format($sum_line_pay, 2) ?></b></td>
                        <td style="font-size: 16px;text-align: right;border-top: 1px solid black;border-bottom: 1px solid black">
                            <b><?= number_format($line_remain, 2) ?></b></td>
                        <td style="font-size: 16px;text-align: right;border-top: 1px solid black;border-bottom: 1px solid black"></td>
                    </tr>
                <?php endif; ?>
            <?php endfor ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <tfoot>
    <tr>
        <td style="font-size: 16px;border-top: 1px solid black"></td>
        <td style="font-size: 16px;border-top: 1px solid black"></td>
        <td style="font-size: 18px;border-top: 1px solid black"><b>รวมทั้งสิ้น</b></td>
        <td style="font-size: 18px;text-align: right;border-top: 1px solid black;border-bottom: 1px solid black">
            <b style="color: green"><?= number_format($sum_line_total_all, 2) ?></b></td>
        <td style="font-size: 16px;text-align: right;border-top: 1px solid black;border-bottom: 1px solid black">
            <b><?= number_format($sum_line_pay_all, 2) ?></b></td>
        <td style="font-size: 18px;text-align: right;border-top: 1px solid black;border-bottom: 1px solid black">
            <b style="color: red"><?= number_format($line_remain_all, 2) ?></b></td>
        <td style="font-size: 18px;text-align: right;border-top: 1px solid black;border-bottom: 1px solid black"></td>
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
function getOrder($route_id, $f_date, $t_date, $company_id, $branch_id)
{

    $data = [];
    if ($route_id != null) {
        $sql = "SELECT t2.id,t2.customer_id, t2.order_no, t2.order_date , sum(t2.line_total_credit) as total_credit
              FROM query_sale_mobile_data_new2 as t2
             WHERE  t2.order_date >=" . "'" . date('Y-m-d H:i:s', strtotime($f_date)) . "'" . " 
             AND t2.order_date <=" . "'" . date('Y-m-d H:i:s', strtotime($t_date)) . "'" . " 
             AND t2.route_id =" . $route_id . " 
             AND t2.sale_channel_id = 1
             AND t2.payment_method_id = 2
             AND t2.company_id=" . $company_id . " AND t2.branch_id=" . $branch_id;

        $sql .= " GROUP BY t2.id,t2.customer_id, t2.order_no, t2.order_date";
        $sql .= " ORDER BY t2.order_no , t2.customer_id, t2.order_date";
        $query = \Yii::$app->db->createCommand($sql);
        $model = $query->queryAll();
        if ($model) {
            for ($i = 0; $i <= count($model) - 1; $i++) {

                array_push($data, [
                    'order_id' => $model[$i]['id'],
                    'customer_id' => $model[$i]['customer_id'],
                    'customer_name' => \backend\models\Customer::findName($model[$i]['customer_id']),
                    'order_no' => $model[$i]['order_no'],
                    'order_date' => $model[$i]['order_date'],
                    'total_credit' => $model[$i]['total_credit'],
                    'total_pay' => getPaytrans($model[$i]['id'], $model[$i]['customer_id']),
                ]);
            }
        }
    }

    return $data;
}

function getPaytrans($order_id, $customer_id)
{
    $pay_total = 0;
    if ($order_id) {
        $model = \common\models\QueryPaymentReceive::find()->where(['order_id' => $order_id, 'customer_id' => $customer_id])->sum('payment_amount');
        $pay_total = $model;
    }
    return $pay_total;
}

function getPayline($order_id, $customer_id)
{
    $data = [];
    if ($order_id) {
        $model = \common\models\QueryPaymentReceive::find()->where(['order_id' => $order_id, 'customer_id' => $customer_id])->andFilterWhere(['>', 'payment_amount', 0])->all();
        if ($model) {
            foreach ($model as $value) {
                array_push($data, [
                    'journal_no' => $value->journal_no,
                    'journal_date' => date('d/m/Y H:i:', strtotime($value->trans_date)),
                    'total_pay' => number_format($value->payment_amount),
                ]);
            }
        }
    }
    return $data;
}

?>

<?php
$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/jquery.table2excel.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$js = <<<JS
 $(function(){
     $("td[colspan=6]").find(".table-detail").hide();
    $(".btn-show-more").click(function(event) {
        event.stopPropagation();
        var target = $(event.target);
        if ( target.closest("td").attr("colspan") > 1 ) {
            target.slideUp();
        } else {
            target.closest("tr").next().find(".table-detail").slideToggle();
        }                    
    });
    
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
