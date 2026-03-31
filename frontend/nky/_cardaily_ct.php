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


$ct_group_id = 0;
$m_ct = \backend\models\Customergroup::find()->where(['like', 'name', 'CT'])->one();
if($m_ct){
    $ct_group_id = $m_ct->id;
}

$model_cj = null;
$sql = "SELECT customer_code,customer_name,route_code,branch_no,product_id,product.name as prd_name FROM query_order_ct_summary left join product on query_order_ct_summary.product_id = product.id";
$sql .= " WHERE (date(order_date) BETWEEN '" . $from_date . "' AND '" . $to_date . "')";
if($route_id!=null){
    $where_item = "";
    for($i=0;$i<count($route_id);$i++){
        if($i==count($route_id)-1){
            $where_item .= "'".$route_id[$i]."'";
        }else{
            $where_item .= "'".$route_id[$i]."',";
        }
    }
    $sql .= " AND delivery_route_id in (".$where_item.")";
}
if($product_id!=null || $product_id!=0){
    $sql .= " AND product_id = '" . $product_id . "'";
}

if($ct_group_id > 0){
    $sql .= " AND query_order_ct_summary.customer_group_id = '" . $ct_group_id . "'";
}

$sql .= " GROUP BY customer_code,customer_name,route_code,branch_no,product_id,prd_name";
$sql .= " ORDER BY prd_name ASC, customer_code ASC";

$model_cj = \Yii::$app->db->createCommand($sql)->queryAll();
//print_r($model_cj);return;

$model_cj_data = null;
$sql = "SELECT * FROM query_order_ct_summary";
$sql .= " WHERE (date(order_date) BETWEEN '" . $from_date . "' AND '" . $to_date . "')";
if($route_id!=null){
    // $sql .= " AND delivery_route_id = '" . $route_id . "'";
    $where_item = "";
    for($i=0;$i<count($route_id);$i++){
        if($i==count($route_id)-1){
            $where_item .= "'".$route_id[$i]."'";
        }else{
            $where_item .= "'".$route_id[$i]."',";
        }
    }
    $sql .= " AND delivery_route_id in (".$where_item.")";
}
if($product_id!=null || $product_id !=0){
    $sql .= " AND product_id = '" . $product_id . "'";
}
if($ct_group_id > 0){
    $sql .= " AND customer_group_id = '" . $ct_group_id . "'";
}
$model_cj_data = \Yii::$app->db->createCommand($sql)->queryAll();
//print_r($model_cj_data);return;
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

        .sortable {
            cursor: pointer;
            color: blue;
        }
        .sortable:hover {
            text-decoration: underline;
        }

    </style>
    <!--    <script src="vendor/jquery/jquery.min.js"></script>-->
    <!--    <script type="text/javascript" src="js/ThaiBath-master/thaibath.js"></script>-->
</head>
<body>
<div class="row">
    <div class="col-lg-9">
        <form action="<?= \yii\helpers\Url::to(['adminreport/printcarct'], true) ?>" method="post" id="form-search">
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
                                'placeholder' => 'วันที่',
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
                            'name' => 'route_id',
                            'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['status'=>1,'branch_id'=>1])->all(), 'id', 'name'),
                            'value' => $route_id,
                            'options' => [
                                'placeholder' => '--สายส่ง--'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => true,
                            ]
                        ])
                        ?>
                    </td>
                    <td>
                        <?php
                        echo \kartik\select2\Select2::widget([
                            'name' => 'product_id',
                            'data' => \yii\helpers\ArrayHelper::map(\backend\models\Product::find()->where(['status'=>1])->all(), 'id', 'name'),
                            'value' => $product_id,
                            'options' => [
                                'placeholder' => '--เลือกสินค้า--'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ]
                        ])
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


</div>
<?php
$grand_total = 0;
$day_arr = [];
$column_total = [];
if ($from_date != null && $to_date != null) {
    $days = round(abs(strtotime($from_date) - strtotime($to_date)) / 86400) + 1;
    if ($days > 0) {
        $st_day = date('d', strtotime($from_date));
        for ($i = 0; $i < $days; $i++) {
            if ($i == 0) {
                array_push($day_arr, (int)$st_day);
            } else {
                array_push($day_arr, $st_day + $i);
            }
        }
    }
    // echo '<br>จํานวนวันที่ค้นหา : ' . $days . ' วัน';
}
if($day_arr != null){
    for($i = 0; $i <= count($day_arr)-1; $i++){
        array_push($column_total, ['day' => (int)$day_arr[$i], 'value' => 0]);
    }
}
?>
<br/>
<div id="div1">
    <table class="table-header" width="100%">
        <tr>
            <td style="text-align: center; font-size: 20px; font-weight: bold">รายงานจำนวนขายสายส่ง CT</td>
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

    ?>
    <table id="table-data">
        <thead>
        <tr style="font-weight: bold;">
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">#</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;" class="sortable" onclick="sortTable(1)">สาขา</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;" class="sortable" onclick="sortTable(2)">ชื่อลูกค้า</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;" class="sortable" onclick="sortTable(3)">สินค้า</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;" class="sortable" onclick="sortTable(4)">สายส่ง</td>
            <?php for ($i = 0; $i <= count($day_arr) - 1; $i++): ?>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= $day_arr[$i] ?></td>
            <?php endfor; ?>
            <td style="text-align: right;padding: 8px;border: 1px solid grey;background-color: mediumseagreen" class="sortable" onclick="sortTable(<?=count($day_arr)+ 5?>)">รวม</td>
        </tr>
        </thead>
        <tbody>
        <?php for ($x = 0; $x <= count($model_cj) - 1; $x++): ?>
            <?php
            $line_total = 0;
            ?>
            <tr>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= $x + 1 ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= $model_cj[$x]['branch_no'] ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= $model_cj[$x]['customer_name'] ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= \backend\models\Product::findName($model_cj[$x]['product_id']) ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= $model_cj[$x]['route_code'] ?></td>
                <?php for ($i = 0; $i <= count($day_arr) - 1; $i++): ?>
                    <?php
                    $qty = getQty($model_cj_data, $model_cj[$x]['customer_code'], $day_arr[$i], $model_cj[$x]['product_id']);
                    $line_total += $qty;
                    $grand_total += $qty;

                    foreach ($column_total as &$value) {
                        if ($value['day'] == $day_arr[$i]) {
                            $value['value'] += $qty;
                        }
                    }

                    ?>
                    <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= $qty==0 ? '-' : number_format($qty, 0) ?></td>
                <?php endfor; ?>
                <td style="text-align: right;padding: 8px;border: 1px solid grey;background-color: mediumseagreen">
                    <b><?= $line_total==0 ? '-' : number_format($line_total, 0) ?></b></td>
            </tr>
        <?php endfor; ?>
        </tbody>
        <tfoot>
        <tr>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;"></td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;"></td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;"></td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;"></td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;"><b>รวม</b></td>
            <?php for ($i = 0; $i <= count($day_arr) - 1; $i++): ?>
                <?php $col_total = 0;?>
                <?php foreach ($column_total as &$value) {
                    if ($value['day'] == $day_arr[$i]) {
                        $col_total = $value['value'];
                    }
                }?>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><b><?= $col_total==0 ? '-' : number_format($col_total,0)?></b></td>
            <?php endfor; ?>
            <td style="text-align: right;padding: 8px;border: 1px solid grey;background-color: mediumseagreen"><b><?= number_format($grand_total, 0) ?></b></td>
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
function getQty($model,$customer_code,$day,$product_id){
    $qty = 0;
    if($model != null){
        for($i = 0; $i <= count($model) - 1; $i++){
            if($model[$i]['customer_code'] == $customer_code && $model[$i]['product_id'] == $product_id){
                if((int)date('d',strtotime($model[$i]['order_date'])) == (int)$day){
                    $qty = ($qty+$model[$i]['qty']);
                }
            }
        }
    }
    return $qty;
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

function sortTable(n) {
  let table = document.getElementById("table-data");
  let rows = table.tBodies[0].rows;
  let switching = true;
  let dir = "asc"; 
  let switchcount = 0;

  while (switching) {
    switching = false;
    for (let i = 0; i < (rows.length - 1); i++) {
      let shouldSwitch = false;
      let x = rows[i].getElementsByTagName("TD")[n];
      let y = rows[i + 1].getElementsByTagName("TD")[n];

      if (!x || !y) continue;

      let xVal = x.innerText.trim();
      let yVal = y.innerText.trim();

      // Clean commas for numeric comparison
      let xNum = xVal.replace(/,/g, '');
      let yNum = yVal.replace(/,/g, '');

      if (xNum !== '' && !isNaN(xNum) && yNum !== '' && !isNaN(yNum)) {
        xVal = Number(xNum);
        yVal = Number(yNum);
      } else {
        xVal = xVal.toLowerCase();
        yVal = yVal.toLowerCase();
      }

      if (dir == "asc" && xVal > yVal) {
        shouldSwitch = true;
      } else if (dir == "desc" && xVal < yVal) {
        shouldSwitch = true;
      }

      if (shouldSwitch) {
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        switchcount++;
        break;
      }
    }
    if (!switching && switchcount == 0 && dir == "asc") {
      dir = "desc";
      switching = true;
    }
  }
  // Re-number the # column after sorting
  for (let i = 0; i < rows.length; i++) {
    rows[i].getElementsByTagName("TD")[0].innerText = i + 1;
  }
}
JS;
$this->registerJs($js, static::POS_END);
?>
