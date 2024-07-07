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
    ->andFilterWhere(['sale_from_mobile'=>1])
    ->andFilterWhere(['order_channel_id'=>$find_route_id])
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
        body {
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

<form action="<?= \yii\helpers\Url::to(['salereport/comsale'], true) ?>" method="post" id="form-search">
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
                    'name' => 'find_route_id',
                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', 'name'),
                    'value' => $find_route_id,
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
<table class="table-title" id="table-data">
    <tr>
        <td rowspan="2" style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b>สายส่ง</b></td>
        <td rowspan="2" style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b>ทะเบียนรถ</b></td>
        <td colspan="2" style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b>คนขับ</b></td>
        <td rowspan="2" style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b>จำนวน</b></td>
        <td rowspan="2" style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b>ราคารวม</b></td>
        <td colspan="3" style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 0px solid gray"><b>ค่าคอม</b></td>
    </tr>
    <tr>
        <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b>คนที่1</b></td>
        <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b>คนที่2</b></td>
        <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b>ค่าคอม</b></td>
        <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b>พิเศษ</b></td>
        <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b>รวม</b></td>
    </tr>
    <?php
     $total_qty_all = 0;
     $total_amt_all = 0;
     $total_com_all = 0;
     $total_special_all = 0;
     $total_com_sum_all = 0;
    $route_emp_count = 0;
    $com_rate = 0;
    ?>
    <?php foreach($model_order_mobile as $value):?>
    <?php

        if($value->emp_1 > 0){
            $route_emp_count +=1;
        }
        if($value->emp_2 > 0){
            $route_emp_count +=1;
        }
        $com_rate = getComRate($route_emp_count, $company_id, $branch_id);
        ?>
    <?php $route_total = getRouteSum($value->order_channel_id,$from_date,$to_date,$company_id,$branch_id);?>
     <tr>
         <td style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?=\backend\models\Deliveryroute::findName($value->order_channel_id)?></td>
         <td style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?=\backend\models\Car::findName($value->car_ref_id)?></td>
         <td style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?=\backend\models\Employee::findName2($value->emp_1)?></td>
         <td style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?=\backend\models\Employee::findName2($value->emp_2)?></td>
         <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?=number_format($route_total[0]['total_qty'])?></td>
         <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?=number_format($route_total[0]['total_amt'])?></td>
         <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?=$com_rate?></td>
         <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"></td>
         <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 0px solid gray"></td>
     </tr>
        <?php
             $order_data = getOrder($value->order_channel_id,$from_date,$to_date,$company_id,$branch_id);
             for($m=0;$m<=count($order_data)-1;$m++):
        ?>
             <?php
                 $total_qty_all = $total_qty_all +  (double)$order_data[$m]['total_qty'];
                 $total_amt_all = $total_amt_all +  (double)$order_data[$m]['total_amt'];
                 ?>
             <tr style="background-color: #d0e9c6">
                 <td colspan="4" style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">วันที่ขาย <?=$order_data[$m]['order_date']?></td>
                 <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?=number_format($order_data[$m]['total_qty'])?></td>
                 <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?=number_format($order_data[$m]['total_amt'])?></td>
                 <td style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?=number_format($order_data[$m]['total_qty'] * $com_rate)?></td>
                 <td style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"></td>
                 <td style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 0px solid gray"></td>
             </tr>
        <?php endfor;?>
    <?php endforeach;?>
    <tfoot>
    <tr>
        <td  colspan="4" style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b>รวมทั้งหมด</b></td>
        <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b><?=number_format($total_qty_all)?></b></td>
        <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b><?=number_format($total_amt_all)?></b></td>
        <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b><?=number_format($total_com_all)?></b></td>
        <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><b><?=number_format($total_special_all)?></b></td>
        <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 0px solid gray"><b><?=number_format($total_com_sum_all)?></b></td>
    </tr>
    </tfoot>

</table>


<br />
<table width="100%" class="table-title">
    <td style="text-align: right">
        <button id="btn-export-excel" class="btn btn-secondary">Export Excel</button>
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
function getOrder($route_id, $f_date, $t_date, $company_id, $branch_id)
{

    $data = [];
    if ($route_id != null) {
        $sql = "SELECT t2.order_no, date(t2.order_date) as order_date, SUM(t3.qty) as total_qty, SUM(t3.line_total) as total_amt 
              FROM orders as t2 INNER  JOIN order_line as t3 ON t3.order_id = t2.id
             WHERE  t2.order_date >=" . "'" . date('Y-m-d H:i:s', strtotime($f_date)) . "'" . " 
             AND t2.order_date <=" . "'" . date('Y-m-d H:i:s', strtotime($t_date)) . "'" . " 
             AND t2.order_channel_id =" . $route_id . " 
             AND t2.company_id=" . $company_id . " AND t2.branch_id=" . $branch_id;

        $sql .= " GROUP BY t2.order_no, date(t2.order_date)";
        $sql .= " ORDER BY t2.order_no ASC";
        $query = \Yii::$app->db->createCommand($sql);
        $model = $query->queryAll();
        if ($model) {
            for ($i = 0; $i <= count($model) - 1; $i++) {

                array_push($data, [
                    'order_no' => $model[$i]['order_no'],
                    'order_date' => $model[$i]['order_date'],
                    'total_qty' => $model[$i]['total_qty'],
                    'total_amt' => $model[$i]['total_amt'],
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
        $sql = "SELECT t2.order_no, SUM(t3.qty) as total_qty, SUM(t3.line_total) as total_amt 
              FROM orders as t2 INNER  JOIN order_line as t3 ON t3.order_id = t2.id
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

function getComRate($count,$company_id,$branch_id){
    $rate = 0;
    $model = \backend\models\Salecom::find()->where(['emp_qty'=>$count,'company_id'=>$company_id,'branch_id'=>$branch_id])->one();
    if($model){
        $rate = $model->com_extra;
    }
    return $rate;
}

?>

<?php
$this->registerJsFile(\Yii::$app->request->baseUrl.'/js/jquery.table2excel.js',['depends' => [\yii\web\JqueryAsset::className()]]);
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
JS;
$this->registerJs($js, static::POS_END);
?>
