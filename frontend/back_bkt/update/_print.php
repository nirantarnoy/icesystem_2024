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

$model_emp_counting = null;

if ($from_date != null && $to_date != null && $find_emp_user_id != null) {
    $find_user_id = [];
//    for($x=0;$x<=count($find_emp_id)-1;$x++){
//        array_push($find_user_id, \backend\models\User::findUserIdEmpId($find_emp_id[$x]));
//    }
    //print_r($find_user_id);
    if ($find_emp_id != null) {
        $model_emp_counting = \backend\models\Dailycount::find()->select(['user_id'])->where(['company_id' => $company_id, 'branch_id' => $branch_id])->andFilterWhere(['in','user_id', $find_emp_user_id])->andFilterWhere(['BETWEEN', 'trans_date', $from_date, $to_date])->groupBy('user_id')->all();
    } else {
        $model_emp_counting = \backend\models\Dailycount::find()->select(['user_id'])->where(['company_id' => $company_id, 'branch_id' => $branch_id])->andFilterWhere(['BETWEEN', 'trans_date', $from_date, $to_date])->groupBy('user_id')->all();
    }
}else{
    $model_emp_counting = \backend\models\Dailycount::find()->select(['user_id'])->where(['company_id' => $company_id, 'branch_id' => $branch_id])->andFilterWhere(['date(trans_date)'=>date('Y-m-d')])->groupBy('user_id')->all();
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

<form action="<?= \yii\helpers\Url::to(['dailycount/print'], true) ?>" method="post" id="form-search">
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
                $is_driver = $branch_id == 1 ? 1 : 6;
                echo \kartik\select2\Select2::widget([
                    'name' => 'find_emp_id',
                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\Employee::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1, 'position' => [5, 13]])->all(), 'id', 'fname'), // nky
                    //'data' => \yii\helpers\ArrayHelper::map(\backend\models\Employee::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1, 'position' => [2, 3]])->all(), 'id', 'fname'),
                    // 'data' => \yii\helpers\ArrayHelper::map(\backend\models\Employee::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1, 'position' => [16, 17]])->all(), 'id', 'fname'),
                    'value' => $find_emp_id,
                    'options' => [
                        'placeholder' => '--พนักงาน--',
                        'onchange'=> 'findUser($(this))',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'multiple' => true,
                    ]
                ]);
                ?>
            </td>
            <td>
                <?php
                echo \kartik\select2\Select2::widget([
                    'name' => 'find_emp_user_id',
                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\User::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1])->all(), 'id', 'username'),
                    // 'data' => \yii\helpers\ArrayHelper::map(\backend\models\Employee::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'status' => 1, 'position' => [16, 17]])->all(), 'id', 'fname'),
                    'value' => $find_emp_user_id,
                    'options' => [
                        'placeholder' => '--ผู้ใช้งาน--',

                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'multiple' => true,
                    ]
                ]);
                ?>
            </td>
<!--            <td>-->
<!---->
<!--                <select name="fine_emp_user_id" id="" class="form-control emp-user-id">-->
<!--                    <option value="-1">--เลือกผู้ใช้งาน--</option>-->
<!--                </select>-->
<!--            </td>-->
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
            <td style="text-align: center; font-size: 20px; font-weight: bold">รายงานนับจริง</td>
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
            <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;border-left: 1px solid gray">
                <b>วันที่</b></td>
            <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b>เลขที่ใบผลิต</b></td>
            <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b>สินค้า</b></td>
            <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray">
                <b>จำนวน</b></td>

        </tr>
        <?php
        $total_qty_all = 0;

        ?>
        <?php if ($model_emp_counting != null): ?>
            <?php foreach ($model_emp_counting as $value): ?>
                <tr>
                    <td colspan="4"
                        style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;border-left: 1px solid gray;background-color: #1aa67d;color: white">
                        <b><?= \backend\models\Employee::findNameFromUserId($value->user_id) ?></b>
                    </td>
                </tr>
                <?php
                $product_data = getProductgroup($value->user_id, $from_date, $to_date, $company_id, $branch_id);
                ?>
                <?php if ($product_data != null): ?>
                    <?php for ($m=0;$m<=count($product_data)-1;$m++): ?>
                        <?php
                        $product_total_qty = getLinesum($value->user_id,$product_data[$m]['product_id'], $from_date, $to_date, $company_id, $branch_id);
                        ?>
                        <tr>
                            <td colspan="3"
                                style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;border-left: 1px solid gray;background-color: #c3a1fa;color: black">
                                <b><?= $product_data[$m]['product_name']?></b>
                            </td>
                            <td style="text-align: right;font-weight: bold;background-color: #c3a1fa">
                                <?=number_format($product_total_qty)?>
                            </td>
                        </tr>
                    <?php
                    $line_count = getLinecount($value->user_id,$product_data[$m]['product_id'], $from_date, $to_date, $company_id, $branch_id);
                    ?>
                    <?php if ($line_count != null): ?>
                        <?php for ($x = 0; $x <= count($line_count) - 1; $x++): ?>
                            <?php $total_qty_all = ($total_qty_all + $line_count[$x]['qty']); ?>
                            <tr>
                                <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;border-left: 1px solid gray"><?= $line_count[$x]['trans_date'] ?></td>
                                <td style="text-align: center;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?= $line_count[$x]['journal_no'] ?></td>
                                <td style="text-align: left;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?= $line_count[$x]['product_name'] ?></td>
                                <td style="text-align: right;border-top: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray"><?= $line_count[$x]['qty'] ?></td>
                            </tr>
                        <?php endfor; ?>
                    <?php endif; ?>
                    <?php endfor;?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <tfoot>
        <tr>
            <td colspan="3" style="text-align: right">ยอดนับรวม</td>
            <td style="text-align: right"><b><?= number_format($total_qty_all, 2) ?></b></td>
        </tr>
        </tfoot>

    </table>
    <table style="width: 100%;border: 0px;">
        <tr>
            <td style="text-align: right;border: 0px;">
                FM-WAT-04 แก้ไขครั้งที่: 00 <br />
                ประกาศใช้วันที่: 01/01/2566
            </td>
        </tr>
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

function getProductgroup($user_id, $from_date, $to_date, $company_id, $branch_id)
{
    $data = [];
    if($from_date != null && $to_date != null){
        $model = \backend\models\Dailycount::find()->select(['product_id'])->where(['user_id' => $user_id, 'company_id' => $company_id, 'branch_id' => $branch_id])->andFilterWhere(['BETWEEN', 'trans_date', $from_date, $to_date])->groupBy('product_id')->all();

    }else{
        $model = \backend\models\Dailycount::find()->select(['product_id'])->where(['user_id' => $user_id, 'company_id' => $company_id, 'branch_id' => $branch_id])->andFilterWhere(['date(trans_date)'=>date('Y-m-d')])->groupBy('product_id')->all();
    }
    foreach ($model as $value) {
        array_push($data, [
            'product_id' => $value->product_id,
            'product_name' => \backend\models\Product::findName($value->product_id),

        ]);
    }

    return $data;
}

function getLinecount($user_id, $product_id, $from_date, $to_date, $company_id, $branch_id)
{
    $data = [];
    if($from_date != null && $to_date != null){
        $model = \backend\models\Dailycount::find()->where(['user_id' => $user_id, 'product_id' => $product_id, 'company_id' => $company_id, 'branch_id' => $branch_id])->andFilterWhere(['BETWEEN', 'trans_date', $from_date, $to_date])->all();
    }else{
        $model = \backend\models\Dailycount::find()->where(['user_id' => $user_id, 'product_id' => $product_id, 'company_id' => $company_id, 'branch_id' => $branch_id])->andFilterWhere(['date(trans_date)'=>date('Y-m-d')])->all();
    }


    foreach ($model as $value) {
        array_push($data, [
            'trans_date' => date('Y-m-d H:i:s', strtotime($value->trans_date)),
            'journal_no' => $value->journal_no,
            'product_name' => \backend\models\Product::findName($value->product_id),
            'qty' => $value->qty,
        ]);
    }

    return $data;
}
function getLinesum($user_id, $product_id, $from_date, $to_date, $company_id, $branch_id)
{
    $total_qty = 0;
    $model = \backend\models\Dailycount::find()->where(['user_id' => $user_id, 'product_id' => $product_id, 'company_id' => $company_id, 'branch_id' => $branch_id])->andFilterWhere(['BETWEEN', 'trans_date', $from_date, $to_date])->sum('qty');
   if($model){
       $total_qty = $model;
   }

    return $total_qty;
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
function findUser(e){
    var emp_id = e.val();
    alert(emp_id);
}     
JS;
$this->registerJs($js, static::POS_END);
?>