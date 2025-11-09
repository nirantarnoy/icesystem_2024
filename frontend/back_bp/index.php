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
        <form action="<?= \yii\helpers\Url::to(['prodrecbalanceqty/index'], true) ?>" method="post" id="form-search">
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
                    <td style="width: 20%">
                        <?php
                        echo \kartik\select2\Select2::widget([
                            'name' => 'find_product_id',
                            'data' => \yii\helpers\ArrayHelper::map(\backend\models\Product::find()->where(['status' => 1])->all(), 'id', function ($data) {
                                return $data->name;
                            }),
                            'value' => $find_product_id,
                            'options' => [
                                'placeholder' => '--เลือกสินค้า--'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => false,
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


    </div>
</div>

<br/>
<div id="div1">
    <table class="table-header" width="100%">
        <tr>
            <td style="text-align: center; font-size: 20px; font-weight: bold">รายงานยอดคงเหลือตั๋วผลิต</td>
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

    $sql = "SELECT stock_trans.id,stock_trans.qty,product.name,stock_trans.trans_date,stock_trans.product_id,stock_trans.journal_no";
    $sql .= " FROM stock_trans INNER JOIN product ON stock_trans.product_id = product.id";
    $sql .= " WHERE date(trans_date) >=" . "'" . date('Y-m-d', strtotime($from_date)) . "'" . " AND date(trans_date) <=" . "'" . date('Y-m-d', strtotime($to_date)). "'";
    $sql .= " AND activity_type_id in(15,26,27) AND stock_trans.status <> 500";
    if($find_product_id != null){
        $sql .= " AND product_id = " . $find_product_id;
    }

    $query = \Yii::$app->db->createCommand($sql);
    $modelx = $query->queryAll();


    ?>
    <table id="table-data">
        <tr style="font-weight: bold;">
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">วันที่</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">เลขที่รับเข้า</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">สินค้า</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">จำนวนรับเข้า</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">เสีย</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">เบิกเติม</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">จำนวนเบิกใช้งาน</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">ปรับปรุง</td>
            <td style="text-align: right;padding: 8px;border: 1px solid grey;background-color: skyblue;">คงเหลือ</td>

        </tr>

        <?php
        $all_total_qty = 0;
        if ($modelx):?>

        <?php for($i=0;$i<=count($modelx)-1;$i++):?>
           <?php
                $line_scrap_qty = checkProdrecScrap($modelx[$i]['id']);
                $line_issue_refill_qty = checkProdrecRefill($modelx[$i]['id']);
                $issue_qty = checkIssueQty($modelx[$i]['id']);
                $adjust_qty = checkAdjustQty($modelx[$i]['id']);
                $line_total_qty = ($modelx[$i]['qty']-$issue_qty)-$line_scrap_qty - $line_issue_refill_qty - $adjust_qty;
                $all_total_qty += $line_total_qty;
                ?>
            <tr>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= date('d/m/Y', strtotime($modelx[$i]['trans_date'])) ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?= $modelx[$i]['journal_no'] ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;"><?=$modelx[$i]['name']?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;color: green;"><?= number_format($modelx[$i]['qty'],0) ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;color: red;"><?= number_format($line_scrap_qty,0) ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;color: red;"><?= number_format($line_issue_refill_qty,0) ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;color: red;"><?= number_format($issue_qty,0) ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey;color: red;"><?= number_format($adjust_qty,0) ?></td>
                <td style="text-align: right;padding: 8px;border: 1px solid grey;background-color: skyblue;"><?=number_format($line_total_qty,0)?></td>
            </tr>
                <?php endfor;?>

        <?php
        endif;
        ?>
        <tfoot>
          <tr>
              <td colspan="8" style="text-align: right;padding: 8px;border: 1px solid grey;background-color: skyblue;"><b>รวม</b></td>
              <td style="text-align: right;padding: 8px;border: 1px solid grey;background-color: skyblue;"><b><?=number_format($all_total_qty,0)?></b></td>
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

function checkProdrecScrap($prodrec_id){
    $scrap_qty = 0;

    if($prodrec_id){
        $model_qty = \common\models\QueryScrap::find()->where(['prodrec_id'=>$prodrec_id])->sum('qty');
        if($model_qty > 0){
            $scrap_qty = $model_qty;
        }
    }
    return $scrap_qty;
}

function checkProdrecRefill($prodrec_id){
    $issue_refill_qty = 0;

    if($prodrec_id){
        $model_qty = \common\models\ProductionRecIssue::find()->where(['stock_trans_id'=>$prodrec_id,'type_id'=>2])->sum('qty');
        if($model_qty > 0){
            $issue_refill_qty = $model_qty;
        }
    }
    return $issue_refill_qty;
}

function checkIssueQty($prodrec_id){
    $issue_refill_qty = 0;

    if($prodrec_id){
        $model_qty = \common\models\ProductionRecIssue::find()->where(['stock_trans_id'=>$prodrec_id,'type_id'=>1])->sum('qty');
        if($model_qty > 0){
            $issue_refill_qty = $model_qty;
        }
    }
    return $issue_refill_qty;
}

function checkAdjustQty($prodrec_id){
    $adjust_qty = 0;

    if($prodrec_id){
        $model_qty = \common\models\ProductionRecIssueAdjust::find()->where(['stock_trans_id'=>$prodrec_id])->sum('qty');
        if($model_qty > 0){
            $adjust_qty = $model_qty;
        }
    }
    return $adjust_qty;
}

?>
</body>
</html>

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
