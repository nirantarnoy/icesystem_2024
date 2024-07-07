<?php

use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;

$this->title = 'รายงานสรุปค่าคอมมิชชั่น';
$com_date = '';
$f_date = null;
$t_date = null;

if ($view_com_date != null) {
    $com_date = $view_com_date;
} else {
    $com_date = date('d/m/Y') . ' - ' . date('d/m/Y');
}

if ($com_date != '') {
    $date_data = explode(' - ', $com_date);
    $fdate = null;
    $tdate = null;
    if ($date_data > 1) {
        $xdate = explode('/', $date_data[0]);
        if (count($xdate) > 1) {
            $fdate = $xdate[2] . '-' . $xdate[1] . '-' . $xdate[0];
        }
        $xdate2 = explode('/', $date_data[1]);
        if (count($xdate2) > 1) {
            $tdate = $xdate2[2] . '-' . $xdate2[1] . '-' . $xdate2[0];
        }
    }

    $f_date = date('Y-m-d', strtotime($fdate));
    $t_date = date('Y-m-d', strtotime($tdate));

}


?>

<?php
//echo GridView::widget([
//    'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,
//    'showPageSummary' => true,
//    'pjax' => true,
//    'striped' => true,
//    'hover' => true,
//    'options' => [
//        'style' => 'font-size: 14px;'
//    ],
//    'toolbar' => [
////        [
////            'content' =>
////               '<input type="text" class="form-control">' . ' '.
////                Html::a('<i class="fas fa-search"></i>', '', [
////                    'class' => 'btn btn-outline-secondary',
////                    'title'=>Yii::t('app', 'Reset Grid'),
////                    'data-pjax' => 0,
////                ]),
////            'options' => ['class' => 'btn-group mr-2']
////        ],
//        '{toggleData}',
//        '{export}',
//
//    ],
//    'panel' => ['type' => 'warning', 'heading' => 'รายงานแสดงยอดขายแยกตามพนักงานขาย'],
//    'toggleDataContainer' => ['class' => 'btn-group mr-2'],
//    'columns' => [
//        ['class' => 'kartik\grid\SerialColumn'],
//        'fname',
//        'lname',
//       'Cash',
//       'Credit',
//        [
//            'attribute' => '1',
//
//        ],
//        '2',
//        '3',
//        '4',
//        '5',
//        '6',
//        '7',
//        '8',
//    ],
//]);
?>
<?php
$model_emp = null;
$model = \backend\models\Product::find()->all();

if ($view_emp_id != null) {
    $model_emp = \backend\models\Employee::find()->where(['id' => $view_emp_id])->all();
} else {
    $model_emp = \backend\models\Employee::find()->all();
}

?>
<form id="form-export" action="index.php?r=salereportemp/empcomlist" method="post">
    <div class="row">
        <div class="col-lg-3">
            <label for="">เลือกวันที่</label>
            <?php
            echo DateRangePicker::widget([
                'name' => 'com_date',
                'value' => $com_date,
                'convertFormat' => true,
                'readonly' => true,
                'pluginOptions' => [
                    'format' => 'DD/MM/YYYY',
                    'locale' => [
                        'format' => 'd/m/Y'
                    ],
                ]
            ]);
            ?>
            <!--        <input type="text" class="form-control" placeholder="DD/MM/YYYY">-->
        </div>
        <div class="col-lg-3">
            <label for="">พนักงาน</label>
            <?php echo Select2::widget([
                'name' => 'emp_id',
                'value' => $view_emp_id,
                'data' => ArrayHelper::map(\backend\models\Employee::find()->all(), 'id', function ($data) {
                    return $data->fname . ' ' . $data->lname;
                }),
                'options' => [
                    'placeholder' => '--เลือกพนักงาน--',
                    'multiple' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-3">
            <label for="" style="color: white">เรียกดูข้อมูล</label><br>
            <button type="submit" class="btn btn-success">เรียกดูข้อมูล</button>
        </div>
        <div class="col-lg-3" style="text-align: right">
            <label for="" style="color: white">เรียกดูข้อมูล</label><br>
            <div type="button" class="btn btn-primary" onclick="submit_export($(this))">Export Excel</div>
        </div>
    </div>
</form>
<br>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-striped table-bordered">
            <thead>
            <tr style="font-size: 12px;">
                <th style="text-align: center" rowspan="2">#</th>
                <th style="text-align: center" rowspan="2">รหัส</th>
                <th rowspan="2">ชื่อ-นามสกุล</th>
                <th style="text-align: right;background-color: #44ab7d;color: white" rowspan="2">เงินสด</th>
                <th style="text-align: right;background-color: #255985;color: white" rowspan="2">เงินเชื่อ</th>
                <?php foreach ($model as $value): ?>
                    <th colspan="2" style="text-align: center"><?= $value->code ?>
                    </th>
                <?php endforeach; ?>
                <th style="text-align: right;background-color: #e4606d;color: white" rowspan="2">รวมปกติ</th>
                <th style="text-align: right;background-color: #e4606d;color: white" rowspan="2">รวมฟรี</th>
                <th style="text-align: right;background-color: #e4606d;color: white" rowspan="2">จำนวนรวม</th>
                <th style="text-align: right;background-color: #ec4844;color: white" rowspan="2">ยอดเงินรวม</th>
                <th style="text-align: right;background-color: #258faf;color: white" rowspan="2">Rate Com</th>
                <th style="text-align: right;background-color: #258faf;color: white" rowspan="2">คอมมิชชั่น</th>
                <th style="text-align: right;background-color: #258faf;color: white">เงินพิเศษ</th>
                <th style="text-align: right;background-color: #258faf;color: white" rowspan="2">รวมค่าคอม</th>
            </tr>
            <tr style="font-size: 12px;">
                <!--                <th width="5%" style="text-align: center"></th>-->
                <!--                <th style="text-align: center">รหัส</th>-->
                <!--                <th>ชื่อ-นามสกุล</th>-->
                <!--                <th style="text-align: right;background-color: #44ab7d;color: white">เงินสด</th>-->
                <!--                <th style="text-align: right;background-color: #e4606d;color: white">เงินเชื่อ</th>-->
                <?php foreach ($model as $value): ?>
                    <th>จำนวน</th>
                    <th style="background-color: #B4B9BE">ยอดเงิน</th>
                <?php endforeach; ?>
                <!--                <th style="text-align: right;background-color: #258faf;color: white">Rate Com</th>-->
                <!--                <th style="text-align: right;background-color: #258faf;color: white">คอมมิชชั่น</th>-->
                <th style="text-align: right;background-color: #258faf;color: white">>3,500</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0; ?>
            <?php foreach ($model_emp as $value): ?>
                <?php $i += 1; ?>
                <?php $line_com = 0; ?>
                <?php $line_amt = 0; ?>
                <?php $line_sum_qty = 0; ?>
                <?php $line_sum_amt = 0; ?>
                <?php $line_sum_qty_free = 0;$line_com_rate=0; ?>
                <?php $extra = 0; ?>
                <tr style="font-size: 12px;">
                    <td style="text-align: center"><?=$i; ?></td>
                    <td style="text-align: center"><?= $value->code ?></td>
                    <td><?= $value->fname . ' ' . $value->lname ?></td>
                    <td style="text-align: right;background-color: #44ab7d;color: white"><?= findCash($value->id, $f_date, $t_date) ?></td>
                    <td style="text-align: right;background-color: #255985;color: white"><?= findCredit($value->id, $f_date, $t_date) ?></td>
                    <?php foreach ($model as $value2): ?>
                        <?php
                        $line_qty = findProductqty($value->id, $value2->id, $f_date, $t_date);
                        $line_amt = findProduct($value->id, $value2->id, $f_date, $t_date);
                        ?>
                        <?php

                        $line_sum_amt = $line_sum_amt + $line_amt;
                        if($line_sum_amt >0){
                            $line_com_rate = findComrate($value->id, $f_date, $t_date);
                        }

                        if ($line_amt == 0) {
                            $line_sum_qty_free = $line_sum_qty_free + $line_qty;
                        }
                        if ($line_amt > 0) {
                            $line_sum_qty = $line_sum_qty + $line_qty;
                        }
                        ?>
                        <td style="text-align: right"><?= $line_qty; ?></td>
                        <td style="text-align: right;background-color: #B4B9BE"><?= $line_amt; ?></td>
                    <?php endforeach; ?>
                    <?php $extra = findComextrarate($value->id, $line_sum_amt,$f_date, $t_date); ?>
                    <td style="text-align: right;background-color: #b8a2e0;color: black"><?= $line_sum_qty; ?></td>
                    <td style="text-align: right;background-color: #b8a2e0;color: black"><?= $line_sum_qty_free; ?></td>
                    <td style="text-align: right;background-color: #b8a2e0;color: black"><?= $line_sum_qty; ?></td>
                    <td style="text-align: right;background-color: #b8a2e0;color: black"><?= $line_sum_amt; ?></td>
                    <td style="text-align: right;background-color: #258faf;color: white"><?= $line_com_rate; ?></td>
                    <td style="text-align: right;background-color: #258faf;color: white"><?= $line_sum_qty * $line_com_rate; ?></td>
                    <td style="text-align: right;background-color: #258faf;color: white"><?= $extra ?></td>
                    <td style="text-align: right;background-color: #258faf;color: white"><?= ($line_sum_qty * $line_com_rate) + $extra; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
function findCash($emp_id, $f_date, $t_date)
{
    $c = 0;
    if ($emp_id) {
        $model = \common\models\QuerySaleorderByEmp::find()->where(['payment_method_id' => 1, 'employee_id' => $emp_id])->andFilterWhere(['between', 'order_date', $f_date, $t_date])->sum('qty * price');
        if ($model) {
            $c = $model;
        }
    }
    return $c;
}

function findCredit($emp_id, $f_date, $t_date)
{
    $c = 0;
    if ($emp_id) {
        $model = \common\models\QuerySaleorderByEmp::find()->where(['payment_method_id' => 2, 'employee_id' => $emp_id])->andFilterWhere(['between', 'order_date', $f_date, $t_date])->sum('qty * price');
        if ($model) {
            $c = $model;
        }
    }
    return $c;
}

function findProduct($emp_id, $product_id, $f_date, $t_date)
{
    $c = 0;
    if ($emp_id && $product_id) {
        $model = \common\models\QuerySaleorderByEmp::find()->where(['product_id' => $product_id, 'employee_id' => $emp_id])->andFilterWhere(['between', 'order_date', $f_date, $t_date])->sum('qty * price');
        if ($model) {
            $c = $model;
        }
    }
    return $c;
}

function findProductqty($emp_id, $product_id, $f_date, $t_date)
{
    $c = 0;
    if ($emp_id && $product_id) {
        $model = \common\models\QuerySaleorderByEmp::find()->where(['product_id' => $product_id, 'employee_id' => $emp_id])->andFilterWhere(['between', 'order_date', $f_date, $t_date])->sum('qty');
        if ($model) {
            $c = $model;
        }
    }
    return $c;
}


function findComrate($emp_id, $f_date, $t_date)
{
    $car_id = 0;
    $c = 0;
    if($emp_id){
        $model = \common\models\QueryCarEmpData::find()->where(['emp_id' => $emp_id])->andFilterWhere(['between','trans_date',$f_date,$t_date])->one();
        if($model){
            $model_cnt = \common\models\QueryCarDailyEmpCount::find()->where(['car_id' => $model->car_id_])->andFilterWhere(['between','trans_date',$f_date,$t_date])->one();
            if ($model_cnt) {
                if ($model_cnt->emp_qty) {
                    $sql = "SELECT sale_com.com_extra,sale_com.emp_qty FROM car INNER JOIN sale_com ON car.sale_com_id=sale_com.id WHERE car.id=" . $model_cnt->car_id;
                    $query = \Yii::$app->db->createCommand($sql)->queryAll();
                    if ($query != null) {
                        //return 300;
                        //print_r($query);return;
                        // foreach ($query as $value){
                        $emp_count = $model_cnt->emp_qty;
                        if ($emp_count == $query[0]['emp_qty']) {
                            if($emp_count == 1){
                                $c = $query[0]['com_extra'];
                            }else{
                                $c = ($query[0]['com_extra'] / 2);
                            }

                        } else {
                            $c = 0.75;
                        }

                        // }

                    }
                }
            }
        }
    }

//    if ($emp_id) {
//        $model = \common\models\QueryCarDailyEmpCount::find()->where(['car_id' => $car_id])->one();
//        if ($model) {
//            if ($model->emp_qty) {
//                $sql = "SELECT sale_com.com_extra,sale_com.emp_qty FROM car INNER JOIN sale_com ON car.sale_com_id=sale_com.id WHERE car.id=" . $car_id;
//                $query = \Yii::$app->db->createCommand($sql)->queryAll();
//                if ($query != null) {
//                    //print_r($query);return;
//                    // foreach ($query as $value){
//                    $emp_count = $model->emp_qty;
//                    if ($emp_count == $query[0]['emp_qty']) {
//                        $c = $query[0]['com_extra'];
//                    } else {
//                        $c = 0.75;
//                    }
//
//                    // }
//
//                }
//            }
//        } else {
////            $c= 33;
//        }
//    }
    return $c;
}

function findComextrarate($emp_id, $sale_total_amt, $f_date, $t_date)
{
    $c = 0;
    if ($emp_id) {
        $model = \common\models\CarEmp::find()->where(['emp_id' => $emp_id])->one();
        $modelx = \common\models\QueryCarEmpData::find()->where(['emp_id' => $emp_id])->andFilterWhere(['between','trans_date',$f_date,$t_date])->one();
        if($modelx) {
            $model_cnt = \common\models\QueryCarDailyEmpCount::find()->where(['car_id' => $modelx->car_id_])->andFilterWhere(['between', 'trans_date', $f_date, $t_date])->one();
            if($model_cnt){
                if($model_cnt->emp_qty > 1){
                    $c =0;
                    return $c;
                }
            }
        }
        if ($model) {
            if ($model->car_id) {
                $sql = "SELECT sale_com_summary.com_extra,sale_com_summary.sale_price FROM car INNER JOIN sale_com_summary ON car.sale_com_extra=sale_com_summary.id WHERE car.id=" . $model->car_id;
                $query = \Yii::$app->db->createCommand($sql)->queryAll();
                if ($query != null) {
                    if ($sale_total_amt > $query[0]['sale_price']) {
                        $c = $query[0]['com_extra'];
                    } else {
                        $c = 0;
                    }

                }
            }
        } else {
//            $c= 33;
        }
    }
    return $c;
}

function findCarempcount($car_id)
{
    $c = 0;
    if ($car_id) {
        $model = \common\models\CarEmp::find()->where(['car_id' => $car_id])->count('emp_id');
        $c = $model;
    }
    return $c;
}

?>

<?php
$js = <<<JS
$(function(){
    
});
function submit_export(e){
    $("form#form-export").attr('action','index.php?r=salereportemp/export');
    $("form#form-export").submit();
}
JS;
$this->registerJs($js, static::POS_END);
?>
