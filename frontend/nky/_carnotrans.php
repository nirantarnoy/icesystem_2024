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


$model_cj_data = null;
$sql = '';
$model_cj = null;
if($day_count !=null){
    if($day_count[0] == 60){
        $sql = "SELECT * FROM query_customer_no_trans_over_60_day";
    }else{
        $sql = "SELECT * FROM query_customer_no_trans_over_30_day";
    }
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
        $sql .= " WHERE delivery_route_id in (".$where_item.")";
    }
    $sql .= " ORDER BY code";

    $model_cj = \Yii::$app->db->createCommand($sql)->queryAll();
}

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

    </style>
    <!--    <script src="vendor/jquery/jquery.min.js"></script>-->
    <!--    <script type="text/javascript" src="js/ThaiBath-master/thaibath.js"></script>-->
</head>
<body>
<div class="row">
    <div class="col-lg-9">
        <form action="<?= \yii\helpers\Url::to(['adminreport/printcarnotrans'], true) ?>" method="post" id="form-search">
            <table class="table-header" style="width: 100%;font-size: 18px;" border="0">
                <tr>

                    <td>
                        <?php
                        echo \kartik\select2\Select2::widget([
                            'name' => 'route_id',
                            'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['status'=>1,'company_id'=>1,'branch_id'=>1])->all(), 'id', 'name'),
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
                            'name' => 'day_count',
                            'data' => ['30'=>'30 วัน','60'=>'60 วัน'],
                            'value' => $day_count,
                            'options' => [
                                'placeholder' => '--เลือกจำนวนวัน--'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => true,
                            ]
                        ])
                        ?>
                    </td>
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

<br/>
<div id="div1">
    <table class="table-header" width="100%">
        <tr>
            <td style="text-align: center; font-size: 20px; font-weight: bold">รายงานลูกค้าไม่เคลื่อนไหวเกิน <?php echo $day_count !=null ? $day_count[0]:' - '?> วัน</td>
        </tr>
    </table>
    <br>
    <?php

    ?>
    <table id="table-data">

        <tr style="font-weight: bold;">
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">#</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">รหัส</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">ชื่อลูกค้า</td>
           <td style="text-align: center;padding: 8px;border: 1px solid grey;">เลขที่สัญญา</td>
          <td style="text-align: center;padding: 8px;border: 1px solid grey;">รายการถัง</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">สายส่ง</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;background-color: mediumseagreen">วันที่ขายล่าสุด</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;background-color: mediumseagreen">เลขที่ขายล่าสุด</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;background-color: mediumseagreen">จำนวนวัน</td>

        </tr>
        <?php if($model_cj != null):?>
        <?php for ($x = 0; $x <= count($model_cj) - 1; $x++): ?>
            <?php
            $date1 = new DateTime($model_cj[$x]['order_date']);
            $date2 = new DateTime("now");

            $diff = $date1->diff($date2);
            ?>
            <tr>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= $x + 1 ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= $model_cj[$x]['code'] ?></td>
                <td style="text-align: left;padding: 8px;border: 1px solid grey;"><?= $model_cj[$x]['name'] ?></td>
                <td style="text-align: left;padding: 8px;border: 1px solid grey;"><?= $model_cj[$x]['contact_no'] ?></td>
               <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= findCustomerAsset($model_cj[$x]['customer_id']) ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= $model_cj[$x]['route_code'] ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= date('d-m-Y H:i:s', strtotime($model_cj[$x]['order_date'])) ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= $model_cj[$x]['order_no'] ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;background-color: mediumseagreen"><?= $diff->days.' วัน' ?></td>
            </tr>
        <?php endfor; ?>
        <?endif;?>
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
function getQty($model,$customer_code,$day){
    $qty = 0;
    if($model != null){
        for($i = 0; $i <= count($model) - 1; $i++){
            if($model[$i]['customer_code'] == $customer_code){
                if((int)date('d',strtotime($model[$i]['order_date'])) == (int)$day){
                    $qty = ($qty+$model[$i]['qty']);
                }
            }
        }
    }
    return $qty;
}

function findCustomerAsset($customer_id){
    $name = '';
    $model = \backend\models\Customerasset::find()->where(['customer_id'=>$customer_id])->all();
    foreach($model as $x){
        if(count($model) > 1){
            $name .= \backend\models\Assetsitem::findOne($x['product_id'])->asset_no.', ';
        }else{
            $name .= \backend\models\Assetsitem::findOne($x['product_id'])->asset_no;
        }
    }
    return $name;
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
