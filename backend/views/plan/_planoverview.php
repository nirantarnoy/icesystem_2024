<?php

use common\models\LoginLog;
use common\models\QuerySalePosData;
use kartik\daterange\DateRangePicker;

$this->title = 'รายการเบิกของประจำวัน';

$user_id = \Yii::$app->user->id;

$company_id = 0;
$branch_id = 0;
if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id = \Yii::$app->user->identity->branch_id;
}

//$model_plan_daily = \common\models\QueryPlanByRoute::find()->select(['route_id','route_name'])->where(['date(trans_date)' => date('Y-m-d')])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])->groupBy('route_id')->all();
$model_plan_daily = \common\models\QueryPlanByRoute::find()->select(['route_id', 'route_name'])->where(['date(trans_date)' => date('Y-m-d', strtotime($from_date)),'company_id' => $company_id, 'branch_id' => $branch_id])->groupBy('route_id')->all();
$model_plan_daily_product = \common\models\QueryPlanByRoute::find()->select(['product_id', 'code'])->where(['date(trans_date)' => date('Y-m-d', strtotime($from_date)),'company_id' => $company_id, 'branch_id' => $branch_id])->groupBy('product_id')->all();
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
<br/>
<div class="row">
    <div class="col-lg-12">
        <p>รายการเบิกของประจำวัน</p>
    </div>
</div>
<form action="<?= \yii\helpers\Url::to(['plan/planreview'], true) ?>" method="post" id="form-search">
    <table class="table-header" style="width: 100%;font-size: 18px;" border="0">
        <tr>

            <td style="width: 20%">
                <?php
                echo DateRangePicker::widget([
                    'name' => 'from_date',
                    // 'value'=>'2015-10-19 12:00 AM',
                    'value' => $from_date != null ? date('Y-m-d', strtotime($from_date)) : date('Y-m-d'),
                    //    'useWithAddon'=>true,
                    'convertFormat' => true,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'วันที่',
                        //  'onchange' => 'this.form.submit();',
                        'autocomplete' => 'off',
                    ],
                    'pluginOptions' => [
                      //  'timePicker' => true,
                        'timePickerIncrement' => 1,
                        'locale' => ['format' => 'Y-m-d'],
                        'singleDatePicker' => true,
                        'showDropdowns' => true,
                        'timePicker24Hour' => true
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
<br />
<div class="row">
    <div class="col-lg-12">
        <table>
            <tr>
                <td style="text-align: center;background-color: #1aa67d">ลำดับ</td>
                <td style="text-align: center;background-color: #1aa67d">สายส่ง</td>
                <td style="text-align: center;background-color: #1aa67d">ทะเบียน</td>
                <td style="text-align: center;background-color: #1aa67d">พนักงานขับ</td>

                <?php
                foreach ($model_plan_daily_product as $value_prod): ?>
                    <td style="text-align: center;background-color: #1aa67d"><?= $value_prod->code ?></td>
                <?php endforeach; ?>

            </tr>
            <?php
            $xi = 0;
            $sum_data = [];
            $list_product = [];
            $sum_qty_total = 0;
            ?>
            <?php foreach ($model_plan_daily as $value): ?>
                <?php
                $xi += 1;
                $car_info = getCar($value->route_id,$company_id,$branch_id, $from_date);
                ?>
                <tr>
                    <td style="text-align: center;"><?= $xi ?></td>
                    <td style="text-align: center;"><?= $value->route_name ?></td>
                    <td style="text-align: center;"><?=$car_info[0]['name']?></td>
                    <td style="text-align: center;"><?=$car_info[0]['driver']?></td>
                    <?php
                    foreach ($model_plan_daily_product as $value_prod): ?>
                        <?php
                        $line_qty = getPlanqty($from_date, $value->route_id, $value_prod->product_id, $company_id, $branch_id);
                        array_push($sum_data, ['product_id' => $value_prod->product_id, 'qty' => $line_qty]);

                        ?>
                        <td style="text-align: center;background-color: <?= $line_qty == 0 ? 'grey' : '' ?>;color:<?= $line_qty == 0 ? 'grey' : '' ?> "><?= number_format($line_qty, 2) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            <tfoot>
            <tr>
                <td colspan="4" style="text-align: right;font-weight: bold;background-color: #1aa67d">รวม</td>
                <?php

                foreach ($model_plan_daily_product as $xval): ?>
                   <?php
                     $prod_total_qty = 0;
                     for($x=0;$x<=count($sum_data)-1;$x++){
                        if($xval->product_id == $sum_data[$x]['product_id']){
                            $prod_total_qty+=$sum_data[$x]['qty'];
                        }
                     }
                   ?>
                    <td style="text-align: center;background-color: #1aa67d"><?= number_format($prod_total_qty, 2) ?></td>
                <?php endforeach; ?>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
</body>
</html>

<?php
function getPlanqty($tdate, $route_id, $product_id, $company_id, $branch_id)
{
    $qty = 100;
    if ($route_id && $product_id && $company_id && $branch_id) {
        $model = \common\models\QueryPlanByRoute::find()->select(['SUM(qty) as qty'])->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'route_id' => $route_id, 'product_id' => $product_id,'date(trans_date)'=>date('Y-m-d',strtotime($tdate))])->one();
        if ($model) {
            $qty = $model->qty;
        }
    }
    return $qty;
}
function getCar($route_id, $company_id, $branch_id , $tdate)
{
    $car = [];
    if ($route_id && $company_id && $branch_id) {
        $model = \common\models\QueryCarRoute::find()->select(['id','name'])->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'delivery_route_id' => $route_id])->one();
        if ($model) {
            $driver = \common\models\QueryCarEmpData::find()->where(['car_id_'=>$model->id,'date(trans_date)'=>date('Y-m-d', strtotime($tdate))])->one();
            if($driver){
                array_push($car,['name'=>$model->name,'driver'=>$driver->fname]);
            }

        }
    }
    return $car;
}

?>
