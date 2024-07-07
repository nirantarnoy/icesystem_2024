<?php

//$year = date("2024");
//$month = date("6");
use kartik\daterange\DateRangePicker;

$days = 0;// cal_days_in_month(CAL_GREGORIAN, 6, 2024);

//echo $days;
$data = [];
//if($find_date != null){
$fdate = date('Y-m-d');
$tdate = date('Y-m-d');
$xdate = explode('-', $from_date);
if ($xdate != null) {
    if (count($xdate) > 1) {
        $fdate = $xdate[2] . '-' . $xdate[1] . '-' . $xdate[0];
    }
}
$xdate2 = explode('-', $to_date);
if ($xdate2 != null) {
    if (count($xdate2) > 1) {
        $tdate = $xdate2[2] . '-' . $xdate2[1] . '-' . $xdate2[0];
    }
}

//echo $from_date . ' - ' . $to_date;

$f_c_date = date_create($fdate);
$n_c_date = date_create($tdate);
$diff_date = date_diff($f_c_date, $n_c_date);
$days = $diff_date->format("%a");


$sql = "SELECT t1.product_id,t3.code,t3.name,t1.price";
$sql .= " FROM order_line as t1 INNER JOIN orders as t2 ON t1.order_id = t2.id inner join product as t3 ON t1.product_id = t3.id";
$sql .= " WHERE  date(t2.order_date) =" . "'" . date('Y-m-d', strtotime($fdate)) . "'";
$sql .= " AND date(t2.order_date) =" . "'" . date('Y-m-d', strtotime($fdate)) . "'";
$sql .= " AND t2.sale_channel_id=2";
$sql .= " AND t2.status in(1,100)";
$sql .= " GROUP BY t1.product_id,t1.price";
$sql .= " ORDER BY t1.product_id,t1.price";
$query = \Yii::$app->db->createCommand($sql);
$modelx = $query->queryAll();
if ($modelx) {
    for ($ix = 0; $ix < count($modelx); $ix++) {
        $data[$ix]['product_id'] = $modelx[$ix]['product_id'];
        $data[$ix]['code'] = $modelx[$ix]['code'];
        $data[$ix]['name'] = $modelx[$ix]['name'];
        $data[$ix]['price'] = (float)$modelx[$ix]['price'];
    }
}


//}
?>
    <form action="<?= \yii\helpers\Url::to(['saleqtysumbyprice/index'], true) ?>" method="post" id="form-search">
        <table class="table-header" style="width: 100%;font-size: 18px;" border="0">

            <tr>

                <td style="width: 20%">
                    <?php
                    echo DateRangePicker::widget([
                        'name' => 'from_date',
                        // 'value'=>'2015-10-19 12:00 AM',
                        'value' => $fdate != null ? date('Y-m-d', strtotime($fdate)) : date('Y-m-d'),
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
                            'locale' => ['format' => 'Y-m-d'],
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
                        'value' => $tdate != null ? date('Y-m-d', strtotime($tdate)) : date('Y-m-d'),
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
                            'locale' => ['format' => 'Y-m-d'],
                            'singleDatePicker' => true,
                            'showDropdowns' => true,
                            'timePicker24Hour' => true
                        ]
                    ]);
                    ?>
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
        <div class="row">
            <div class="col-lg-12" style="text-align: center;">
                <h5>ขายหน้าบ้าน</h5>
            </div>
        </div>
        <br/>
        <?php
        $column_total = [];
        $column_value = [];
        $start_day = date('d', strtotime($fdate));

        for ($k = 0; $k < ($days + 1); $k++) {
            array_push($column_total, ['day' => $start_day + $k, 'value' => 0]);
            array_push($column_value, 0);
        }
        ?>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered" id="table-data">
                    <tr style="background-color: #1ab6cf">
                        <td style="text-align: center;">สินค้า</td>
                        <td style="text-align: center;">ราคา</td>
                        <?php for ($x = 0; $x < count($column_total); $x++): ?>
                            <td style="text-align: center;"><?= $column_total[$x]['day'] ?></td>
                        <?php endfor; ?>
                        <td style="text-align: center;">รวม</td>
                    </tr>
                    <?php
                    $last_product = '';
                    $total_all = 0;

                    if ($data) {
                        for ($ix = 0; $ix < count($data); $ix++) {
                            $is_group = 0;
                            if ($last_product == $data[$ix]['code']) {
                                $is_group = 1;
                            } else {
                                $is_group = 0;
                            }
                            $last_product = $data[$ix]['code'];
                            ?>
                            <tr>
                                <td style="text-align: center;"><?= $is_group == 1 ? '' : $data[$ix]['code'] ?></td>
                                <td style="text-align: center;background-color: #f1b0b7"><?= number_format($data[$ix]['price'], 2) ?></td>
                                <?php
                                $product_price_data = getLineprice($data[$ix]['product_id'], (float)$data[$ix]['price'], $days, $column_total, $fdate, $tdate, $find_sale_type, $is_invoice_req);
                                //   print_r($product_price_data);
                                ?>
                                <?php $line_total = 0; ?>
                                <?php for ($a = 0; $a < ($days + 1); $a++): ?>
                                    <td style="text-align: center;"><?= number_format($product_price_data[$a], 2) ?></td>

                                    <?php
                                    $line_total += $product_price_data[$a];
                                    //  $column_total[$a] = $product_price_data[$a] + $column_total[$a];
                                    $total_all += $product_price_data[$a];
                                    $column_value[$a] = $product_price_data[$a] + $column_value[$a];
                                    ?>
                                <?php endfor; ?>
                                <td style="text-align: right;background-color: #b9ca4a"><?= number_format($line_total, 2) ?></td>
                            </tr>

                            <?php
                        }
                    }
                    ?>
                    <tr style="background-color: #1ab6cf">
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>
                        <?php for ($x = 0; $x < ($days + 1); $x++): ?>
                            <td style="text-align: center;"><?= number_format($column_value[$x], 2) ?></td>
                        <?php endfor; ?>
                        <td style="text-align: right;"><b><?= number_format($total_all, 2) ?></b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <br/>
    <table width="100%" class="table-title">
        <td style="text-align: right">
            <button id="btn-export-excel" class="btn btn-secondary">Export Excel</button>
            <button id="btn-print" class="btn btn-warning" onclick="printContent('div1')">Print</button>
        </td>
    </table>
<?php
function getLineprice($product_id, $price, $days, $column_total, $fdate, $tdate, $find_sale_type, $is_invoice_req)
{
    $data = [];
    if ($product_id != null && $price != null && $days != null) {
        $sql = "SELECT day(t2.order_date) as day,sum(t1.qty) as qty";
        $sql .= " FROM order_line as t1 INNER JOIN orders as t2 ON t1.order_id = t2.id left join customer as t3 on t2.customer_id=t3.id left join delivery_route as t4 on t2.order_channel_id = t4.id";
        $sql .= " WHERE date(t2.order_date) >=" . "'" . date('Y-m-d', strtotime($fdate)) . "'" . " ";
        $sql .= " AND date(t2.order_date) <=" . "'" . date('Y-m-d', strtotime($tdate)) . "'" . " ";
        $sql .= " AND t2.sale_channel_id=2";
        $sql .= " AND t2.status in(1,100)";
        $sql .= " AND t1.product_id=" . $product_id;
        $sql .= " AND t1.price=" . (float)$price;

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
        if ($is_invoice_req != null) {
            $sql .= " AND t3.is_invoice_req =" . $is_invoice_req;
        }

        $sql .= " GROUP BY day(t2.order_date)";
        $sql .= " ORDER BY day(t2.order_date)";
        $query = \Yii::$app->db->createCommand($sql);
        $modelx = $query->queryAll();
        if ($modelx) {
            for ($i = 0; $i < ($days + 1); $i++) {
                $day_has = 0;
                for ($ix = 0; $ix < count($modelx); $ix++) {
                    if ($column_total[$i]['day'] == (int)$modelx[$ix]['day']) {
                        $day_has = $modelx[$ix]['qty'];
                    }
                }
                if ($day_has == 0) {
                    $data[$i] = 0;
                } else {
                    $data[$i] = $day_has;
                }
            }

        } else {
            for ($i = 0; $i < ($days + 1); $i++) {
                $data[$i] = 0;
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
