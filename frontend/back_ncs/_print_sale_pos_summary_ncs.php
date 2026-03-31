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
$model_product_daily = \common\models\StockTrans::find()->select("product_id")->where(['BETWEEN', 'trans_date', date('Y-m-d H:i:s', strtotime($from_date)), date('Y-m-d H:i:s', strtotime($to_date))])->andFilterWhere(['activity_type_id' => 5, 'company_id' => $company_id, 'branch_id' => $branch_id])->groupBy('product_id')->orderBy(['product_id' => SORT_ASC])->all();

$user_login_datetime = '';
$model_c_login = LoginLog::find()->select('MIN(login_date) as login_date')->where(['user_id' => $user_id, 'status' => 1])->one();
if ($model_c_login != null) {
    $user_login_datetime = date('Y-m-d H:i:s', strtotime($model_c_login->login_date));
} else {
    $user_login_datetime = date('Y-m-d H:i:s');
}

$product_header_2 = [];
$product_header_3 = [];
$model_line = null;

$model_product = \backend\models\Product::find()->where(['status' => 1, 'company_id' => $company_id, 'branch_id' => $branch_id])->orderBy(['item_pos_seq' => SORT_ASC])->all();
if ($model_product != null) {
    foreach ($model_product as $value) {
        array_push($product_header_2, [$value->id]);
        array_push($product_header_3, [$value->id]);
    }
}

if ($from_date != null && $to_date != null) {
    $select_fields = [
        't1.customer_id',
        't1.name as customer_name',
        't1.product_id',
        'SUM(t1.qty) as qty',
        'SUM(t1.line_total) as line_total',
        't2.car_name'
    ];
    $group_fields = ['t2.car_name', 't1.customer_id', 't1.product_id'];

    if ($report_type == 2) {
        $select_fields[] = 't1.order_no';
        $select_fields[] = 't1.order_date';
        $group_fields[] = 't1.order_no';
        $group_fields[] = 't1.order_date';
    }

    $model_line = (new \yii\db\Query())
        ->select($select_fields)
        ->from('query_order_customer_product t1')
        ->innerJoin('query_customer_car t2', 't1.customer_id = t2.id')
        ->where(['BETWEEN', 't1.order_date', $from_date, $to_date])
        ->andFilterWhere(['t1.status' => [1, 100]])
        ->andFilterWhere(['>', 't1.qty', 0]);

    if ($find_user_id != null) {
        $model_line = $model_line->andFilterWhere(['t1.created_by' => $find_user_id]);
    }
    if ($is_invoice_req != null) {
        $model_line = $model_line->andFilterWhere(['t1.is_invoice_req' => $is_invoice_req]);
    }
    if ($find_sale_type != null && $find_sale_type != 0) {
        if ($find_sale_type == 1) {
            $model_line = $model_line->andFilterWhere(['t1.payment_method_id' => $find_sale_type]);
        }
        if ($find_sale_type == 2) {
            $model_line = $model_line->andFilterWhere(['or', ['t1.order_channel_id' => 0], ['is', 't1.order_channel_id', new \yii\db\Expression('null')]])->andFilterWhere(['t1.payment_method_id' => $find_sale_type]);
        }
        if ($find_sale_type == 3) {
            $model_line = $model_line->andFilterWhere(['>', 't1.order_channel_id', 0])->andFilterWhere(['t1.is_other_branch' => 0]);
        }
        if ($find_sale_type == 4) {
            $model_line = $model_line->andFilterWhere(['>', 't1.order_channel_id', 0])->andFilterWhere(['t1.is_other_branch' => 1]);
        }
    }

    $model_line = $model_line->groupBy($group_fields)
        ->orderBy(['t2.car_name' => SORT_ASC, 't1.name' => SORT_ASC, 't1.order_date' => SORT_ASC])
        ->all();

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
<div>

    <form action="<?= \yii\helpers\Url::to(['pos/printsummaryposncs'], true) ?>" method="post" id="form-search">
        <input type="hidden" class="btn-order-type" name="btn_order_type" value="<?= $btn_order_type ?>">
        <table class="table-header" style="width: 100%;font-size: 18px;" border="0">
            <tr>
                <td style="padding: 10px;"><span>เรียงตาม <div class="btn-group"><div
                                class="btn btn-sm <?= $btn_order_type == 1 ? "btn-success" : "btn-default" ?> btn-order-date">วันที่ขาย</div><div
                                class="btn btn-sm <?= $btn_order_type == 2 ? "btn-success" : "btn-default" ?> btn-order-price">ราคาขาย</div></div></span>
                </td>
            </tr>
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
                    <select name="report_type" class="form-control" id="">
                        <option value="1" <?= $report_type == 1 ? "selected" : "" ?>>ดูแบบสรุป</option>
                        <option value="2" <?= $report_type == 2 ? "selected" : "" ?>>ดูแบบแยกเลขที่ SO</option>
                    </select>
                </td>
                <td>
                    <select name="find_sale_type" class="form-control" id="">
                        <option value="0">--ประเภทขาย--</option>
                        <option value="1" <?php if ($find_sale_type == 1) {
                            echo "selected";
                        } ?>>ขายสด
                        </option>
                        <option value="2" <?php if ($find_sale_type == 2) {
                            echo "selected";
                        } ?>>ขายเชื่อหน้าบ้าน
                        </option>
                        <option value="3" <?php if ($find_sale_type == 3) {
                            echo "selected";
                        } ?>>ขายเชื่อรถ
                        </option>
                        <option value="4" <?php if ($find_sale_type == 4) {
                            echo "selected";
                        } ?>>ขายเชื่อรถต่างสาขา
                        </option>
                    </select>
                </td>
                <td>
                    <?php
                    echo \kartik\select2\Select2::widget([
                        'name' => 'find_user_id',
                        'data' => \yii\helpers\ArrayHelper::map(\backend\models\User::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1])->all(), 'id', 'username'),
                        'value' => $find_user_id,
                        'options' => [
                            'placeholder' => '--พนักงานขาย--'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ]
                    ]);
                    ?>
                </td>
                <td>
                    <?php
                    echo \kartik\select2\Select2::widget([
                        'name' => 'is_invoice_req',
                        'data' => \yii\helpers\ArrayHelper::map(\backend\helpers\CustomerInvoiceReqType::asArrayObject(), 'id', 'name'),
                        'value' => $is_invoice_req,
                        'options' => [
                            'placeholder' => '--ทั้งหมด--'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => false,
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
                <td style="text-align: center; font-size: 20px; font-weight: bold">รายงานยอดขายแยกตามประเภทสินค้า</td>
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
                <td style="border: 1px solid grey;text-align: center;"><b>ลำดับ</b></td>
                <td style="text-align: center;border: 1px solid grey"><b>รถ</b></td>
                <td style="text-align: center;border: 1px solid grey"><b>ลูกค้า</b></td>
                <?php if ($report_type == 2): ?>
                    <td style="text-align: center;border: 1px solid grey"><b>เลขที่ SO</b></td>
                <?php endif; ?>
                <?php for ($y = 0; $y <= count($product_header_2) - 1; $y++): ?>
                    <td style="text-align: center;border: 1px solid grey"><?= \backend\models\Product::findName($product_header_2[$y]) ?></td>
                <?php endfor; ?>
                <td style="text-align: right;border: 1px solid grey"><b>จำนวน</b>
                </td>
                <td style="text-align: right;border: 1px solid grey"><b>จำนวนเงิน</b></td>
            </tr>
            <?php
            $sum_qty_all = 0;
            $sum_total_all = 0;
            $total_all_qty = 0;
            $line_all_amt = 0;
            $total_all_line_qty_data = [];
            foreach ($product_header_2 as $ph) {
                $total_all_line_qty_data[$ph[0]] = 0;
            }

            $grouped_data = [];
            if ($model_line != null) {
                foreach ($model_line as $row) {
                    $car_name = $row['car_name'] ?: 'ไม่ระบุรถ';
                    $customer_id = $row['customer_id'];
                    $order_no = isset($row['order_no']) ? $row['order_no'] : 'SUM';

                    if (!isset($grouped_data[$car_name])) {
                        $grouped_data[$car_name] = [];
                    }
                    if (!isset($grouped_data[$car_name][$customer_id])) {
                        $grouped_data[$car_name][$customer_id] = [
                            'name' => $row['customer_name'],
                            'orders' => [],
                            'total_qty' => 0,
                            'total_amount' => 0,
                            'product_totals' => []
                        ];
                    }

                    if (!isset($grouped_data[$car_name][$customer_id]['orders'][$order_no])) {
                        $grouped_data[$car_name][$customer_id]['orders'][$order_no] = [
                            'order_date' => isset($row['order_date']) ? $row['order_date'] : '',
                            'products' => [],
                            'total_qty' => 0,
                            'total_amount' => 0
                        ];
                    }

                    $grouped_data[$car_name][$customer_id]['orders'][$order_no]['products'][$row['product_id']] = $row['qty'];
                    $grouped_data[$car_name][$customer_id]['orders'][$order_no]['total_qty'] += $row['qty'];
                    $grouped_data[$car_name][$customer_id]['orders'][$order_no]['total_amount'] += $row['line_total'];

                    $grouped_data[$car_name][$customer_id]['total_qty'] += $row['qty'];
                    $grouped_data[$car_name][$customer_id]['total_amount'] += $row['line_total'];
                    
                    if(!isset($grouped_data[$car_name][$customer_id]['product_totals'][$row['product_id']])){
                         $grouped_data[$car_name][$customer_id]['product_totals'][$row['product_id']] = 0;
                    }
                    $grouped_data[$car_name][$customer_id]['product_totals'][$row['product_id']] += $row['qty'];
                }
            }

            $car_index = 0;
            $colors = ['#e3f2fd', '#fff3e0', '#f1f8e9', '#f3e5f5', '#efebe9', '#fffde7'];
            ?>

            <?php foreach ($grouped_data as $car_name => $customers): ?>
                <?php
                $car_index++;
                $car_total_qty = 0;
                $car_total_amount = 0;
                $car_product_totals = [];
                foreach ($product_header_2 as $ph) {
                    $car_product_totals[$ph[0]] = 0;
                }

                $customer_count = count($customers);
                $first_customer = true;
                $bg_color = $colors[($car_index - 1) % count($colors)];

                $car_row_span = 0;
                foreach ($customers as $cus) {
                    $car_row_span += count($cus['orders']);
                }
                ?>
                <?php foreach ($customers as $cus_id => $cus_data): ?>
                    <?php
                    $car_total_qty += $cus_data['total_qty'];
                    $car_total_amount += $cus_data['total_amount'];
                    $total_all_qty += $cus_data['total_qty'];
                    $line_all_amt += $cus_data['total_amount'];

                    $order_count = count($cus_data['orders']);
                    $first_order = true;
                    $row_span_cus = $order_count;
                    ?>
                    
                    <?php foreach ($cus_data['orders'] as $order_no => $order_data): ?>
                        <tr style="background-color: <?= $bg_color ?>">
                            <?php if ($first_customer && $first_order): ?>
                                <td rowspan="<?= $car_row_span ?>" style="text-align: center;border: 1px solid grey; vertical-align: middle;"><b><?= $car_index ?></b></td>
                                <td rowspan="<?= $car_row_span ?>" style="text-align: center;border: 1px solid grey; vertical-align: middle;"><b><?= $car_name ?></b></td>
                            <?php endif; ?>
                            
                            <?php if ($first_order): ?>
                                <td rowspan="<?= $row_span_cus ?>" style="text-align: left;border: 1px solid grey; vertical-align: middle;">
                                    <b><?= $cus_data['name'] ?></b>
                                </td>
                            <?php endif; ?>

                            <?php if ($report_type == 2): ?>
                                <td style="text-align: left;border: 1px solid grey; font-size: 14px; color: #555;">
                                    <?= $order_no ?> (<?= date('d/m/Y', strtotime($order_data['order_date'])) ?>)
                                </td>
                            <?php endif; ?>

                            <?php for ($k = 0; $k <= count($product_header_3) - 1; $k++): ?>
                                <?php
                                $p_id = $product_header_3[$k][0];
                                $p_qty = isset($order_data['products'][$p_id]) ? $order_data['products'][$p_id] : 0;
                                $total_all_line_qty_data[$p_id] += $p_qty;
                                $car_product_totals[$p_id] += $p_qty;
                                ?>
                                <td style="text-align: center;border: 1px solid grey"><?= $p_qty > 0 ? number_format($p_qty, 1) : '-' ?></td>
                            <?php endfor; ?>
                            <td style="text-align: right;border: 1px solid grey"><?= number_format($order_data['total_qty'], 2) ?></td>
                            <td style="text-align: right;border: 1px solid grey"><?= number_format($order_data['total_amount'], 2) ?></td>
                        </tr>
                        <?php $first_order = false; $first_customer = false; ?>
                    <?php endforeach; ?>


                <?php endforeach; ?>
                <tr style="background-color: #eeeeee;">
                    <td colspan="<?= $report_type == 2 ? 4 : 3 ?>" style="text-align: center;border: 1px solid grey"><b>รวมรถ <?= $car_name ?></b></td>
                    <?php for ($k = 0; $k <= count($product_header_3) - 1; $k++): ?>
                        <td style="text-align: center;border: 1px solid grey"><b><?= $car_product_totals[$product_header_3[$k][0]] > 0 ? number_format($car_product_totals[$product_header_3[$k][0]], 1) : '-' ?></b></td>
                    <?php endfor; ?>
                    <td style="text-align: right;border: 1px solid grey"><b><?= number_format($car_total_qty, 2) ?></b></td>
                    <td style="text-align: right;border: 1px solid grey"><b><?= number_format($car_total_amount, 2) ?></b></td>
                </tr>
            <?php endforeach; ?>

            <tfoot>
            <tr>
                <td colspan="<?= $report_type == 2 ? 3 : 2 ?>" style="font-size: 16px;border: 1px solid grey"></td>
                <td style="font-size: 16px;border: 1px solid grey;text-align: center;"><b>รวมทั้งสิ้น</b></td>
                <?php for ($z = 0; $z <= count($product_header_2) - 1; $z++): ?>
                    <td style="text-align: center;padding: 0px;padding-right: 5px;border: 1px solid grey">
                        <b><?= $total_all_line_qty_data[$product_header_2[$z][0]] > 0 ? number_format($total_all_line_qty_data[$product_header_2[$z][0]], 1) : '-' ?></b>
                    </td>
                <?php endfor; ?>
                <td style="font-size: 18px;text-align: right;border: 1px solid grey">
                    <b><?= number_format($total_all_qty, 2) ?></b></td>
                <td style="font-size: 18px;text-align: right;border: 1px solid grey">
                    <b><?= number_format($line_all_amt, 2) ?></b></td>
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
function getOrderMain($order_id,$product_list_text)
{
    $data = [];
    $sql = "SELECT product_id,sum(qty) as qty,sum(line_total) as line_total FROM order_line WHERE order_id=" . $order_id. " AND product_id in(" . $product_list_text . ")" . " group by product_id";

    $query = \Yii::$app->db->createCommand($sql);
    $model = $query->queryAll();
    if ($model) {
        for ($i = 0; $i <= count($model) - 1; $i++) {

            array_push($data, [
                'product_id' => $model[$i]['product_id'],
                'qty' => $model[$i]['qty'],
                'amount' => $model[$i]['line_total'],
            ]);
        }
    }
    return $data;
}
function getOrderNew($order_id,$product_id)
{
    $data = [];
    $sql = "SELECT sum(qty) as qty,sum(line_total) as line_total FROM order_line WHERE order_id=" . $order_id. " AND product_id=" . $product_id. " group by product_id";

    $query = \Yii::$app->db->createCommand($sql);
    $model = $query->queryAll();
    if ($model) {
        for ($i = 0; $i <= count($model) - 1; $i++) {

            array_push($data, [
                'qty' => $model[$i]['qty'],
                'amount' => $model[$i]['line_total'],
            ]);
        }
    }
    return $data;
}

function getOrderQty2($order_id, $product_id)
{
    $data = 0;
    if ($order_id) {
        $model_qty = \backend\models\Orderline::find()->where(['order_id' => $order_id, 'product_id' => $product_id])->sum('qty');
        if ($model_qty) {
            $data = $model_qty;
//           foreach($model_qty as $value){
//            //   $name = \backend\models\Product::findCode($value->product_id);
//               array_push($data,['product_name'=>$name,'qty'=>$value->qty]);
//           }
        }
    }
    return $data;
}

function getOrderAmount($order_id, $product_id)
{
    $data = 0;
    if ($order_id) {
        $model_amount = \backend\models\Orderline::find()->where(['order_id' => $order_id, 'product_id' => $product_id])->sum('line_total');
        if ($model_amount) {
            $data = $model_amount;
//           foreach($model_qty as $value){
//            //   $name = \backend\models\Product::findCode($value->product_id);
//               array_push($data,['product_name'=>$name,'qty'=>$value->qty]);
//           }
        }
    }
    return $data;
}

function getOrder($product_id, $f_date, $t_date, $find_sale_type, $find_user_id, $company_id, $branch_id, $is_invoice_req, $btn_order_type)
{
    $data = [];
    $sql = "SELECT t2.order_no, t3.code , t3.name, t1.qty, t1.price, t2.order_date, t2.order_channel_id, t1.line_total 
              FROM order_line as t1 INNER JOIN orders as t2 ON t1.order_id = t2.id LEFT  JOIN customer as t3 ON t2.customer_id=t3.id LEFT JOIN delivery_route as t4 on t2.order_channel_id = t4.id
             WHERE  t2.order_date >=" . "'" . date('Y-m-d H:i:s', strtotime($f_date)) . "'" . " 
             AND t2.order_date <=" . "'" . date('Y-m-d H:i:s', strtotime($t_date)) . "'" . " 
             AND t1.product_id=" . $product_id . " 
             AND t2.status <> 3
             AND t2.sale_channel_id = 2
             AND t2.company_id=" . $company_id . " AND t2.branch_id=" . $branch_id;

    if ($find_sale_type != null && $find_sale_type != 0) {
        if ($find_sale_type == 1) {
            $sql .= " AND t2.payment_method_id=" . $find_sale_type;
        }
        if ($find_sale_type == 2) {
            $sql .= " AND (t2.order_channel_id = 0 OR t2.order_channel_id is null) AND t2.payment_method_id=" . $find_sale_type;
        }
        if ($find_sale_type == 3) {
            $sql .= " AND t2.order_channel_id > 0";
            $sql .= " AND t4.is_other_branch = 0";
        }
        if ($find_sale_type == 4) {
            $sql .= " AND t2.order_channel_id > 0";
            $sql .= " AND t4.is_other_branch = 1";
        }
    }
    if ($find_user_id != null) {
        $sql .= " AND t2.created_by=" . $find_user_id;
    }
    if ($is_invoice_req != null) {
        $sql .= " AND t3.is_invoice_req =" . $is_invoice_req;
    }
    // $sql .=" ORDER BY t1.price ASC";
    if ($btn_order_type == 1) {
        $sql .= " ORDER BY t2.order_no ASC";
    } else if ($btn_order_type == 2) {
        $sql .= " ORDER BY t1.price ASC";
    } else {
        $sql .= " ORDER BY t2.order_no ASC";
    }

    $query = \Yii::$app->db->createCommand($sql);
    $model = $query->queryAll();
    if ($model) {
        for ($i = 0; $i <= count($model) - 1; $i++) {
            $customer_code = $model[$i]['code'];
            $customer_name = $model[$i]['name'];
            if ($model[$i]['code'] == null) {
                $customer_code = \backend\models\Deliveryroute::findCode($model[$i]['order_channel_id']);
                $customer_name = \backend\models\Deliveryroute::findName($model[$i]['order_channel_id']);
            }

            array_push($data, [
                'order_no' => $model[$i]['order_no'],
                'cus_code' => $customer_code,
                'cus_name' => $customer_name,
                'qty' => $model[$i]['qty'],
                'sale_price' => $model[$i]['price'],
                'line_total' => $model[$i]['line_total'],
                'order_date' => $model[$i]['order_date'],
            ]);
        }
    }
    return $data;
}

?>

<?php
$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/jquery.table2excel.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$js = <<<JS
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
JS;
$this->registerJs($js, static::POS_END);
?>
