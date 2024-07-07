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
$model_route = null;
$model = \backend\models\Product::find()->all();

if ($view_emp_id != null) {
    $model_emp = \backend\models\Employee::find()->where(['id' => $view_emp_id])->all();
} else {
    $model_emp = \backend\models\Employee::find()->all();
}
if ($view_route_id != null) {
    $model_route = \backend\models\Deliveryroute::find()->where(['id' => $view_route_id])->all();
} else {
    $model_route = \backend\models\Deliveryroute::find()->all();
}

?>
<form id="form-export" action="index.php?r=salereportemp/empcomnew" method="post">
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
            <label for="">สายส่ง</label>
            <?php echo Select2::widget([
                'name' => 'route_id',
                'value' => $view_route_id,
                'data' => ArrayHelper::map(\backend\models\Deliveryroute::find()->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => '--เลือกสายส่ง--',
                    'multiple' => true
                ],
            ]);
            ?>
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
        <!--        <div class="col-lg-3" style="text-align: right">-->
        <!--            <label for="" style="color: white">เรียกดูข้อมูล</label><br>-->
        <!--            <div type="button" class="btn btn-primary" onclick="submit_export($(this))">Export Excel</div>-->
        <!--        </div>-->
    </div>
</form>
<br>
<?php
$date1 = date_create($f_date);
$date2 = date_create($t_date);
$diff = date_diff($date1, $date2);
$cnt = $diff->format("%a");
$max_product_list = [];
//echo $cnt;
//echo $diff->format("%R%a days");
?>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td rowspan="2" width="5%" style="text-align: center;vertical-align: middle">ลำดับ</td>
                <td rowspan="2" style="text-align: center;vertical-align: middle">สาขา</td>
                <td rowspan="2" style="text-align: center;vertical-align: middle">ชื่อลูกค้า</td>
                <td rowspan="2" style="text-align: center;vertical-align: middle">ราคา</td>
                <?php for ($x = 0; $x <= $cnt; $x++): ?>
                    <?php
                    $date1 = date_create($f_date);
                    $date2 = date_create($t_date);
                    date_add($date1, date_interval_create_from_date_string("$x days"));
                    $prod_cnt = gettopcountproduct(date_format($date1, "Y-m-d"), date_format($date2, "Y-m-d"));
                    // echo $prod_cnt;
                    ?>
                    <td colspan="<?= count($prod_cnt) ?>"
                        style="text-align: center;vertical-align: middle;background-color: #258faf;color: white"><?= date_format($date1, "d-M"); ?></td>
                <?php endfor; ?>
            </tr>
            <tr>
                <!--                <td width="5%">ลำดับ</td>-->
                <!--                <td>สาขา</td>-->
                <!--                <td>ชื่อลูกค้า</td>-->
                <!--                <td>ราคา</td>-->
                <?php for ($x = 0; $x <= $cnt; $x++): ?>
                    <?php
                    $date1 = date_create($f_date);
                    $date2 = date_create($t_date);
                    date_add($date1, date_interval_create_from_date_string("$x days"));
                    $prod_cnt = gettopcountproduct(date_format($date1, "Y-m-d"), date_format($date2, "Y-m-d"));
                    ?>
                    <?php
                    if (count($prod_cnt) > 0) {
                        foreach ($prod_cnt as $val):?>
                            <?php array_push($max_product_list,$val->product_id);?>
                            <td style="text-align: center;background-color: #e4606d"><?= $val->prod_code ?></td>
                        <?php endforeach;
                    } else {
                        ?>
                        <td style="text-align: center"></td>
                    <?php } ?>

                <?php endfor; ?>
                <!--                <td>PB</td>-->
                <!--                <td>PS</td>-->
                <!--                <td>K</td>-->
                <!--                <td>PB</td>-->
                <!--                <td>PS</td>-->
                <!--                <td>K</td>-->
                <!--                <td>PB</td>-->
                <!--                <td>PS</td>-->
                <!--                <td>K</td>-->
                <!--                <td>PB</td>-->
                <!--                <td>PS</td>-->
                <!--                <td>K</td>-->
            </tr>
            <?php
            echo findCustomer($view_route_id, $f_date, $t_date, $cnt, 0, $max_product_list);
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php
function findCustomer($route_id, $f_date, $t_date, $cnt, $emp_id, $max_product_list)
{
    $html = '';
    $model = \common\models\QuerySaleorderByRoute::find()->where(['between', 'order_date', $f_date, $t_date])->andFilterWhere(['rt_id' => $route_id])->all();
    $i = 0;
    if ($model) {
        foreach ($model as $value) {
            $i += 1;
            $html .= '<tr>';
            $html .= '<td style="text-align: center">' . $i . '</td>';
            $html .= '<td>' . $value->branch_no . '</td>';
            $html .= '<td>' . $value->cus_name . '</td>';
            $html .= '<td style="text-align: center">' . $value->rt_id . '</td>';

            for ($x = 0; $x <= $cnt; $x++) {
                $date1 = date_create($f_date);
                $date2 = date_create($t_date);
                date_add($date1, date_interval_create_from_date_string("$x days"));


                    $prod_cnt = gettopcountproduct2(date_format($date1, "Y-m-d"), date_format($date2, "Y-m-d"), $value->customer_id,$max_product_list);
                    $html.= $prod_cnt;
//                    if (count($prod_cnt) > 0) {
//                        foreach ($prod_cnt as $val) {
//                            $html .= '<td style="text-align: center">' . $val->qty . '</td>';
//                        }
//                    } else {
//                        $html .= '<td></td>';continue;
//                    }



            }
            $html .= '</tr>';
        }
    }
    return $html;
}

function gettopcountproduct($fdate, $tdate)
{
    $cnt = null;
    if ($fdate != null) {
        $cnt = \common\models\QuerySaleorderByRoute::find()->select(['product_id', 'prod_code'])->distinct('product_id')->where(['between', 'order_date', $fdate, $fdate])->all();
    }
    return $cnt;
}

function gettopcountproduct2($fdate, $tdate, $customer_id,$product_id)
{
    $cnt = '';

    if ($fdate != null) {
        $has_order = \common\models\QuerySaleorderByRoute::find()->where(['between', 'order_date', $fdate, $fdate])->andFilterWhere(['customer_id' => $customer_id])->groupBy('product_id')->sum('qty');
        if($has_order >0){
            for($i=0;$i<=count($product_id)-1;$i++) {
                $model = \common\models\QuerySaleorderByRoute::find()->select('qty')->where(['between', 'order_date', $fdate, $fdate])->andFilterWhere(['customer_id' => $customer_id, 'product_id' => $product_id[$i]])->groupBy('product_id')->one();
                if($model){
                    $cnt.='<td style="text-align: center">'.$model->qty.'</td>';
                }else{
                    $cnt.='<td style="text-align: center">0</td>';
                }
            }
        }else{
            $cnt.='<td style="text-align: center">0</td>';
        }

    }
    return $cnt;
}
//function gettopcountproduct2($fdate, $tdate, $customer_id,$product_id)
//{
//    $cnt = null;
//    if ($fdate != null) {
//        $cnt = \common\models\QuerySaleorderByRoute::find()->select('qty')->where(['between', 'order_date', $fdate, $fdate])->andFilterWhere(['customer_id' => $customer_id,'product_id'=>$product_id])->groupBy('product_id')->all();
////        $cnt = \common\models\QuerySaleorderByRoute::find()->select('qty')->where(['between', 'order_date', $fdate, $fdate])->groupBy('product_id')->all();
//    }
//    return $cnt;
//}

?>
