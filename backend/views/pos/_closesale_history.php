<?php

use common\models\LoginLog;
use common\models\QuerySalePosData;

$this->title = 'ยอดขายสรุปประจำวันแยกกะ';

$user_id = \Yii::$app->user->id;

$company_id = 1;
$branch_id = 1;
if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id = \Yii::$app->user->identity->branch_id;
}

$url_to_find_date = \yii\helpers\Url::to(['post/finduserdate', true]);

//$user_login_time = \backend\models\User::findLogintime($user_id);
$user_login_datetime = '';
$user_logout_datetime = '';
$t_date = date('Y-m-d H:i:s');
//$model_c_login = LoginLog::find()->where(['user_id' => $user_id, 'status' => 1])->andFilterWhere(['date(login_date)' => date('Y-m-d')])->one();
$model_c_login = \common\models\LoginLogCal::find()->select('MAX(login_date) as login_date')->where(['user_id' => $user_id, 'status' => 1])->one();
//$model_c_login = LoginLog::find()->select('MIN(login_date) as login_date')->where(['user_id' => $user_id, 'status' => 1])->one();
//$model_c_login = LoginLog::find()->select('MIN(login_date) as login_date')->where(['user_id' => $user_id,'date(login_date)'=>date('Y-m-d')])->one();
if ($model_c_login) {
    $user_login_datetime = date('Y-m-d H:i:s', strtotime($model_c_login->login_date));
} else {
    $user_login_datetime = date('Y-m-d H:i:s');
}

$model_c_logout = LoginLog::find()->select('MAX(logout_date) as logout_date')->where(['user_id' => $user_id, 'status' => 2])->one();
if ($model_c_logout != null) {
    $user_logout_datetime = date('Y-m-d H:i:s', strtotime($model_c_logout->logout_date));
} else {
    $user_logout_datetime = date('Y-m-d H:i:s');
}

$is_close_status = '';
if (\Yii::$app->session->getFlash('after-save') !== null) {
    $is_close_status = 'close';
}


//echo $user_login_datetime; //return;

//$model_product_daily = \common\models\QueryProductTransDaily::find()->where(['date(trans_date)' => date('Y-m-d', strtotime($user_login_datetime))])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])->groupBy('product_id')->all();
?>
<br/>
<form id="form-find" action="<?=\yii\helpers\Url::to(['pos/manageclose', true])?>" method="post">
    <div class="row">
        <div class="col-lg-3">
            <label for="">พนักงาน</label>
            <?php
            echo \kartik\select2\Select2::widget([
                'name' => 'find_user_id',
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\User::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', 'username'),
                'value' => $find_user_id,
                'options' => [
                    'placeholder' => '--พนักงาน--',
                    'onchange'=>'
                  //  alert($(this).val());
                        $.ajax({
                          "type":"post",
                          "dataType": "html",
                          "async": false,
                          "url": "index.php?r=pos/finduserdate",
                          "data": {"user_id": $(this).val()},
                          "success": function(data) {
                           // alert(data);
                            $("#user-date-trans").html(data);
                          },
                          "error": function(err){
                              alert("Data error");
                          }
                             
                        });  
                    ',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => false,
                ]
            ]);
            ?>
        </div>
        <div class="col-lg-3">
            <label for="">ช่วงเวลา</label>
            <?php

            echo \kartik\select2\Select2::widget([
                'name' => 'user_shift',
                'data' => \yii\helpers\ArrayHelper::map(\common\models\SaleDailySum::find()->select(['trans_shift','date(trans_date) as trans_date'])->where(['company_id'=>$company_id,'branch_id'=>$branch_id,'emp_id'=>$find_user_id])->groupBy(['trans_shift','date(trans_date)'])->orderBy(['trans_date'=>SORT_DESC])->all(),'trans_shift','trans_date'),
                'value' => $find_user_shift,
                'options' => [
                        'id'=> 'user-date-trans',
                    'placeholder' => '--เลือกวันที่--',
                    'onChange'=>'$("#form-find").submit();'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => false,
                ]
            ]);
            ?>
        </div>
        <div class="col-lg-3">

        </div>
        <div class="col-lg-3">

        </div>
    </div>
</form>
<br/>
<form id="form-sale-end"
      action="<?= \yii\helpers\Url::to(['pos/editsaleclose'], true) ?>"
      method="post">
    <input type="hidden"
           name="close_date"
           value="<?= date('Y-m-d') ?>">
    <input type="hidden"
           name="close_from_time"
           value="<?= \backend\models\User::findLogintime($user_id) ?>">
    <input type="hidden"
           name="close_to_time"
           value="<?= date('H:i') ?>">

    <!--    <input type="submit" value="ok">-->

    <input type="hidden" id="close-status" value="<?= $is_close_status ?>">
    <input type="hidden" name="find_user_shift" value="<?= $find_user_shift ?>">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>
                        สินค้า
                    </th>
                    <th style="text-align: right">
                        ยอดยกมา
                    </th>
                    <th style="text-align: right">
                        ยอดผลิต
                    </th>
                    <th style="text-align: right">
                        แปรสภาพ
                    </th>
                    <th style="text-align: right;width: 8%">
                        ปรับสต๊อก
                    </th>
                    <th style="text-align: right">
                        ขายสด(จำนวน)
                    </th>
                    <th style="text-align: right">
                        ขายเชื่อ(จำนวน)
                    </th>
                    <th style="text-align: right">
                        รวมจำนวน
                    </th>
                    <th style="text-align: right">
                        ขายสด(เงิน)
                    </th>
                    <th style="text-align: right">
                        ขายเชื่อ(เงิน)
                    </th>
                    <th style="text-align: right">
                        รวมเงิน
                    </th>
                    <th style="text-align: right">
                        เสีย
                    </th>
                    <th style="text-align: right">
                        ยอดยกไป
                    </th>
                    <th style="text-align: right;width: 8%">
                        นับจริง
                    </th>
                    <th style="text-align: right;width: 8%">
                        +/-
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total_order_cash_qty = 0;
                $total_order_credit_qty = 0;
                $total_order_cash_amount = 0;
                $total_order_credit_amount = 0;
                $total_production_qty = 0;
                $total_balance_in = 0;
                $total_balance_out = 0;
                $total_issue_refill = 0;
                $total_production_repack_qty = 0;
                $total_scrap_qty = 0;
                $total_count_stock = 0;

                $model_history_close = \common\models\SaleDailySum::find()->where(['trans_shift' => $find_user_shift,'emp_id'=>$find_user_id])->all();
                ?>
                <?php foreach ($model_history_close as $value): ?>
                    <?php
                    $total_balance_in = $total_balance_in + $value->balance_in;
                    $total_production_qty = $total_production_qty + $value->total_prod_qty;
                    $total_production_repack_qty = $total_production_repack_qty + $value->prod_repack_qty;
                    $total_order_cash_qty = $total_order_cash_qty + $value->total_cash_qty;
                    $total_order_credit_qty = $total_order_credit_qty + $value->total_credit_qty;
                    $total_order_cash_amount = $total_order_cash_amount + $value->total_cash_price;
                    $total_order_credit_amount = $total_order_credit_amount + $value->total_credit_price;
                    $total_scrap_qty = $total_scrap_qty + $value->scrap_qty;
                    $line_balance_out = ($value->balance_in + $value->total_prod_qty + $value->prod_repack_qty) - ($value->total_cash_qty + $value->total_credit_qty) - $value->issue_refill_qty - $value->scrap_qty;
                    $total_balance_out = $total_balance_out + $line_balance_out;
                    $line_count_stock = $value->real_stock_count;
                    $total_count_stock = $total_count_stock + $line_count_stock;
                    ?>
                    <tr>
                        <td style="text-align: left;vertical-align: middle">
                            <input type="hidden"
                                   name="line_prod_id[]"
                                   value="<?= $value->product_id ?>">
                            <?= \backend\models\Product::findName($value->product_id) ?>
                        </td>
                        <td style="text-align: right;vertical-align: middle">
                            <input type="hidden"
                                   name="line_balance_in_id"
                                   value="<?= 0 ?>">
                            <input type="hidden"
                                   name="line_balance_in[]"
                                   value="<?= $value->balance_in ?>">
                            <?= number_format($value->balance_in, 2) ?>
                        </td>
                        <td style="text-align: right;vertical-align: middle">
                            <input type="hidden"
                                   name="line_production_qty[]"
                                   value="<?= $value->total_prod_qty ?>">
                            <?= number_format($value->total_prod_qty, 2) ?>
                        </td>
                        <td style="text-align: right;vertical-align: middle">
                            <input type="hidden"
                                   name="line_repack_qty[]"
                                   value="<?= $value->prod_repack_qty ?>">
                            <?= number_format($value->prod_repack_qty, 2) ?>
                        </td>
                        <td style="text-align: right;vertical-align: middle">
                            <input type="hidden"
                                   name="line_refill_qty[]"
                                   value="<?= $value->issue_refill_qty ?>">
                            <input type="text" style="text-align: right" class="form-control" name="line_count_new[]"
                                   value=" <?= number_format($value->issue_refill_qty, 2) ?>">

                        </td>
                        <td style="text-align: right;vertical-align: middle">
                            <input type="hidden"
                                   name="line_cash_qty[]"
                                   value="<?= $value->total_cash_qty ?>">
                            <?= number_format($value->total_cash_qty, 2) ?>
                        </td>
                        <td style="text-align: right;vertical-align: middle">
                            <input type="hidden"
                                   name="line_credit_qty[]"
                                   value="<?= $value->total_credit_qty ?>">
                            <?= number_format($value->total_credit_qty, 2) ?>
                        </td>
                        <td style="text-align: right;background-color: #99c5de;vertical-align: middle">
                            <?= number_format($value->total_credit_qty + $value->total_cash_qty, 2) ?>
                        </td>
                        <td style="text-align: right;vertical-align: middle">
                            <input type="hidden"
                                   name="line_cash_amount[]"
                                   value="<?= $value->total_cash_price ?>">
                            <?= number_format($value->total_cash_price, 2) ?>
                        </td>
                        <td style="text-align: right;vertical-align: middle">
                            <input type="hidden"
                                   name="line_credit_amount[]"
                                   value="<?= $value->total_credit_price ?>">
                            <?= number_format($value->total_credit_price, 2) ?>
                        </td>
                        <td style="text-align: right;background-color: #99c5de;vertical-align: middle">
                            <?= number_format($value->total_credit_price + $value->total_cash_price, 2) ?>
                        </td>
                        <td style="text-align: right;vertical-align: middle">
                            <input type="hidden"
                                   name="line_scrap_qty[]"
                                   value="<?= $value->scrap_qty ?>">
                            <?= number_format($value->scrap_qty, 2) ?>
                        </td>
                        <td style="text-align: right;vertical-align: middle">
                            <input type="hidden"
                                   name="line_balance_out[]"
                                   class="line-balance-out"
                                   value="<?= $line_balance_out ?>">
                            <?= number_format($line_balance_out, 2) ?>
                        </td>
                        <td style="text-align: right;vertical-align: middle">
                            <input type="number" min="0" name="line_stock_count[]" style="text-align: right" readonly value="<?=number_format($line_count_stock)?>"
                                   class="form-control line-stock-count" onchange="line_cal($(this));">
                        </td>
                        <td style="text-align: right;vertical-align: middle">
                            <input type="hidden" class="line-diff" name="line_diff[]" value="0">
                            <input type="text" class="form-control line-diff-qty" value="" readonly>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr style="background-color: #99c5de">
                    <td></td>
                    <td style="text-align: right;font-weight: bold">
                        <?= number_format($total_balance_in, 2) ?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?= number_format($total_production_qty, 2) ?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?= number_format($total_production_repack_qty, 2) ?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?= number_format($total_issue_refill, 2) ?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?= number_format($total_order_cash_qty, 2) ?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?= number_format($total_order_credit_qty, 2) ?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?= number_format($total_order_credit_qty + $total_order_cash_qty, 2) ?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?= number_format($total_order_cash_amount, 2) ?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?= number_format($total_order_credit_amount, 2) ?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?= number_format($total_order_cash_amount + $total_order_credit_amount, 2) ?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?= number_format($total_scrap_qty, 2) ?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?= number_format($total_balance_out, 2); ?>
                    </td>
                    <td style="text-align: right;font-weight: bold">
                        <?= number_format($total_count_stock, 2); ?>
                    </td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-lg-12">
            <label for="">รูปภาพจบการขาย</label>
            <a href="#"></a>
        </div>
    </div>
    <br />

    <div class="row"
         style="text-align: left;display: ">
        <div class="col-lg-12">
            <div class="btn btn-success btn-lg btn-save"
                 onclick="submittotal($(this));">
                <i class="fa fa-save"></i>
                บันทึก
            </div>
        </div>
    </div>
</form>
<?php
function getBalancein($product_id, $user_login_datetime, $t_date)
{
    $qty = 0;
    if ($product_id != null) {
        $model = \common\models\BalanceDaily::find()->where(['product_id' => $product_id])->one();
        if ($model) {
            $qty = $model->balance_qty;
        }
    }

    return $qty;
}

function getProdDaily($product_id, $user_login_datetime, $t_date)
{
    $qty = 0;
    if ($product_id != null) {
        $qty = \backend\models\Stocktrans::find()->where(['activity_type_id' => 15, 'production_type' => 1])->andFilterWhere(['product_id' => $product_id])->andFilterWhere(['between', 'trans_date', date('Y-m-d H:i:s', strtotime($user_login_datetime)), date('Y-m-d H:i:s', strtotime($t_date))])->sum('qty');
    }

    return $qty;
}

function getProdRepackDaily($product_id, $user_login_datetime, $t_date)
{
    $qty = 0;
    if ($product_id != null) {
        $qty = \backend\models\Stocktrans::find()->where(['in', 'activity_type_id', [26, 27], 'production_type' => 2])->andFilterWhere(['product_id' => $product_id])->andFilterWhere(['between', 'trans_date', date('Y-m-d H:i:s', strtotime($user_login_datetime)), date('Y-m-d H:i:s', strtotime($t_date))])->sum('qty');
    }

    return $qty;
}

function getIssueRefillDaily($product_id, $user_login_datetime, $t_date)
{
    $qty = 0;
    if ($product_id != null) {
        $qty = \backend\models\Stocktrans::find()->where(['activity_type_id' => 18])->andFilterWhere(['product_id' => $product_id])->andFilterWhere(['between', 'trans_date', date('Y-m-d H:i:s', strtotime($user_login_datetime)), date('Y-m-d H:i:s', strtotime($t_date))])->sum('qty');
    }

    return $qty;
}

function getScrapDaily($product_id, $user_login_datetime, $t_date)
{
    $qty = 0;
    if ($product_id != null) {
        $qty = \backend\models\Scrap::find()->join('inner join', 'scrap_line', 'scrap_line.scrap_id = scrap.id')->where(['scrap_line.product_id' => $product_id])->andFilterWhere(['between', 'scrap.trans_date', date('Y-m-d H:i:s', strtotime($user_login_datetime)), date('Y-m-d H:i:s', strtotime($t_date))])->sum('scrap_line.qty');
    }

    return $qty;
}

//function getOrderCashQty($product_id, $user_id, $user_login_datetime, $t_date)
//{
//    $qty = 0;
//    if ($user_id != null) {
//        $qty = \common\models\QuerySaleDataSummary::find()->where(['created_by' => $user_id, 'product_id' => $product_id])->andFilterWhere(['between', 'order_date', date('Y-m-d H:i:s', strtotime($user_login_datetime)), date('Y-m-d H:i:s', strtotime($t_date))])->andFilterWhere(['LIKE', 'name', 'สด'])->sum('qty');
//    }
//
//    return $qty;
//}
function getOrderCashQty($product_id, $user_id, $user_login_datetime, $t_date)
{
    $qty = 0;
    if ($user_id != null) {
        $qty = \common\models\QuerySalePosData::find()->where(['created_by' => $user_id, 'product_id' => $product_id])->andFilterWhere(['between', 'order_date', date('Y-m-d H:i:s', strtotime($user_login_datetime)), date('Y-m-d H:i:s', strtotime($t_date))])->sum('line_qty_cash');
    }
    return $qty;
}

function getOrderCreditQty($product_id, $user_id, $user_login_datetime, $t_date)
{
    $qty = 0;
    if ($user_id != null) {
        $qty = \common\models\QuerySalePosData::find()->where(['created_by' => $user_id, 'product_id' => $product_id])->andFilterWhere(['between', 'order_date', date('Y-m-d H:i:s', strtotime($user_login_datetime)), date('Y-m-d H:i:s', strtotime($t_date))])->sum('line_qty_credit');
    }
    return $qty;
}

//function getOrderCreditQty($product_id, $user_id, $user_login_datetime, $t_date)
//{
//    $qty = 0;
//    if ($user_id != null) {
//        $qty = \common\models\QuerySaleDataSummary::find()->where(['created_by' => $user_id, 'product_id' => $product_id])->andFilterWhere(['between', 'order_date', date('Y-m-d H:i:s', strtotime($user_login_datetime)), date('Y-m-d H:i:s', strtotime($t_date))])->andFilterWhere(['LIKE', 'name', 'เครดิต'])->sum('qty');
//    }
//    return $qty;
//}

//function getOrderCashAmount($product_id, $user_id, $user_login_datetime, $t_date)
//{
//    $qty = 0;
//    if ($user_id != null) {
//        $qty = \common\models\QuerySalePosPayDaily::find()->where(['created_by' => $user_id])->andFilterWhere(['between', 'payment_date', $user_login_datetime, $t_date])->andFilterWhere(['LIKE', 'name', 'สด'])->sum('payment_amount');
//    }
//
//    return $qty;
//}
function getOrderCashAmount($product_id, $user_id, $user_login_datetime, $t_date)
{
    $qty = 0;
    if ($user_id != null) {
        $qty = \common\models\QuerySalePosData::find()->where(['created_by' => $user_id, 'product_id' => $product_id])->andFilterWhere(['between', 'order_date', date('Y-m-d H:i:s', strtotime($user_login_datetime)), date('Y-m-d H:i:s', strtotime($t_date))])->sum('line_total_cash');
    }
    return $qty;
}

//function getOrderCashAmount($product_id, $user_id, $user_login_datetime, $t_date)
//{
//    $qty = 0;
//    if ($user_id != null) {
//        $qty = \common\models\QuerySaleDataSummary::find()->where(['created_by' => $user_id, 'product_id' => $product_id])->andFilterWhere(['between', 'order_date', date('Y-m-d H:i:s', strtotime($user_login_datetime)), date('Y-m-d H:i:s', strtotime($t_date))])->andFilterWhere(['LIKE', 'name', 'สด'])->sum('line_total');
//    }
//    return $qty;
//}

function getOrderCreditAmount($product_id, $user_id, $user_login_datetime, $t_date)
{
    $qty = 0;
    if ($user_id != null) {
        $qty = \common\models\QuerySalePosData::find()->where(['created_by' => $user_id, 'product_id' => $product_id])->andFilterWhere(['between', 'order_date', date('Y-m-d H:i:s', strtotime($user_login_datetime)), date('Y-m-d H:i:s', strtotime($t_date))])->sum('line_total_credit');
    }
    return $qty;
}

//function getOrderCreditAmount($product_id, $user_id, $user_login_datetime, $t_date)
//{
//    $qty = 0;
//    if ($user_id != null) {
//        $qty = \common\models\QuerySaleDataSummary::find()->where(['created_by' => $user_id, 'product_id' => $product_id])->andFilterWhere(['between', 'order_date', date('Y-m-d H:i:s', strtotime($user_login_datetime)), date('Y-m-d H:i:s', strtotime($t_date))])->andFilterWhere(['LIKE', 'name', 'เครดิต'])->sum('line_total');
//    }
//    return $qty;
//}


//function getBalancein($product_id)
//{
//    $data = [];
//    if ($product_id != null) {
//        $model = \common\models\SaleBalanceOut::find()->where(['product_id' => $product_id, 'status' => 1])->one();
//        if ($model) {
//            array_push($data, ['id' => $model->id, 'qty' => $model->balance_out]);
//        }
//    }
//    return $data;
//}

?>

<?php
$js = <<<JS
  $(function(){
     var x = $("#close-status").val();
     if(x!=''){
         $(".btn-save").hide();
     }else{
         $(".btn-save").show();
     }
  });
  function submittotal(e){
    if(confirm('คุณต้องการทำรายการนี้ใช่หรือไม่ ?')){
        $("form#form-sale-end").submit();
    }
}
function line_cal(e){
      var real_stock = e.val();
      var balance_out = e.closest('tr').find('.line-balance-out').val();
      var line_diff = parseFloat(real_stock) - parseFloat(balance_out);
      e.closest('tr').find('.line-diff-qty').val(line_diff);
      e.closest('tr').find('.line-diff').val(line_diff);
}
JS;

$this->registerJs($js, static::POS_END);
?>
