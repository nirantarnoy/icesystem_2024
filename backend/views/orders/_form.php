<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$issue_data = [];
if ($order_issue_list != null) {
    foreach ($order_issue_list as $value) {
        array_push($issue_data, $value->issue_id);
    }
}

$company_id = 1;
$branch_id = 1;
if (isset($_SESSION['user_company_id'])) {
    $company_id = $_SESSION['user_company_id'];
}
if (isset($_SESSION['user_branch_id'])) {
    $branch_id = $_SESSION['user_branch_id'];
}

$this->registerCss('
//   #table-sale-list {
//       position: fixed;
//       top: 0px; display:none;
//       background-color:white;
//   }
// .tablex-header-fixed {
// position: fixed;
//  top: 0px; display:none;
// background-color:white;
// }
');

?>
<div class="orders-form">
    <input type="hidden" class="page-status" data-var="<?= $model->id ?>" value="<?= $model->isNewRecord ? 0 : 1 ?>">
    <?php $form = ActiveForm::begin(['id' => 'order-form', 'method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <input type="hidden" class="current_id" value="<?= $model->id ?>">
    <input type="hidden" class="current-price-group" value="">
    <input type="hidden" class="remove-list" name="removelist" value="">
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'order_no')->textInput(['value' => $model->isNewRecord ? 'Draft' : $model->order_no, 'readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg-3">
            <?php $model->order_date = $model->isNewRecord ? date('d/m/Y') : date('d/m/Y', strtotime($model->order_date)); ?>
            <?= $form->field($model, 'order_date')->textInput(['id' => 'order-date']) ?>
        </div>
        <div class="col-lg-3">
            <?php
            $x_disabled = !$model->isNewRecord ? true : false;

            ?>
            <?= $form->field($model, 'order_channel_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', 'name'),
                'options' => [
                    'id' => 'delivery-route-id',
                    'readonly' => 'readonly',
                    'placeholder' => '--เลือกสายส่ง--',
                    'onchange' => '
                           route_change($(this));
                        ',
                    'disabled' => $x_disabled,
                ],
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'car_ref_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Car::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', function ($data) {
                    return $data->code . ' ' . $data->name;
                }),
                'options' => [
                    'id' => 'car-ref-id',
                    'disabled' => 'disabled',
                    'onchange' => 'getcaremp($(this));',
                    'placeholder' => '--เลือกรถขาย--'
                ]
            ]) ?>
        </div>
        <!--            <div class="col-lg-3">-->
        <!--                --><?php ////echo $form->field($model, 'customer_id')->Widget(\kartik\select2\Select2::className(), [
        //                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customer::find()->all(), 'id', 'name'),
        //                    'options' => [
        //                        'id' => 'customer-id',
        //                        'placeholder' => '--เลือกลูกค้า--'
        //                    ]
        //                ]) ?>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <?php $filter_status = $model->isNewRecord ? 1 : 2; ?>
            <?php $model->issue_id = $issue_data; ?>
            <?= $form->field($model, 'issue_id')->Widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Journalissue::find()->where(['status' => $filter_status, 'company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', 'journal_no'),
                'options' => [
                    'id' => 'issue-id',
                    // 'disabled' => '',
                    'placeholder' => '--เลือกใบเบิก--',
                    'multiple' => true,
                    'onchange' => 'addIssueorder($(this))',
                ]
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?php $model->order_total_amt_text = number_format($model->order_total_amt); ?>
            <?= $form->field($model, 'order_total_amt_text')->textInput(['readonly' => 'readonly', 'id' => 'order-total-amt-text'])->label('ยอดขาย') ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'status')->textInput(['readonly' => 'readonly', 'value' => $model->isNewRecord ? 'Open' : \backend\helpers\OrderStatus::getTypeById($model->status)]) ?>
        </div>
        <div class="col-lg-3">
            <label class="label" style="color: white">ยืม</label>
            <br>
            <div class="btn-group">
                <?php //if(0>1):?>
                <?php if ($model->issue_id > 0): ?>
                    <div class="btn btn-info btn-transfer" onclick="showtransfer($(this))">โอนย้ายสินค้า</div>
                <?php endif; ?>
                <?php if ($model_has_transfer != null): ?>
                    <div class="btn btn-warning btn-show-has-transfer" onclick="showtransfersale($(this))">
                        รายการยืมสินค้า
                    </div>
                <?php endif; ?>
                <?php //endif; ?>
            </div>
        </div>
    </div>
    <br>
    <?php
    $get_emp_show = \backend\models\Orders::findOrderemp($model->id);
    ?>
    <div class="row">
        <div class="col-lg-10">
            <h5>รายละเอียดการขาย <span class="badge badge-info text-car-emp"><?= $get_emp_show; ?></span></h5>
        </div>
        <div class="col-lg-2" style="text-align: right">
            <div class="btn btn-primary btn-payment" style="display: none"><span class="count-selected"></span>บันทึกชำระเงิน
            </div>
        </div>
    </div>
    <hr>
    <div class="list-detail">

    </div>
    <br/>
    <?= $form->field($model, 'order_total_amt')->hiddenInput(['readonly' => 'readonly', 'id' => 'order-total-amt'])->label(false) ?>
    <div class="form-group">
        <div class="btn btn-primary">บันทึกขายเพิ่มเติม</div>
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="url-customer" data-url="<?= \yii\helpers\Url::to(['orders/find-saledata'], true) ?>"></div>

<div id="paymentModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <form id="form-order-payment" action="<?= \yii\helpers\Url::to(['orders/addpayment2'], true) ?>" method="post">
            <input type="hidden" class="payment-order-id" name="payment_order_id" value="<?= $model->id ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row" style="width: 100%">
                        <div class="col-lg-11">
                            <h2 style="color: #255985"><i class="fa fa-coins"></i> บันทึกชำระเงิน</h2>
                        </div>
                        <div class="col-lg-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>

                </div>
                <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
                <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="label">วันที่</div>
                            <?php
                            // $order_date = date('d/m/Y',strtotime($model->order_date));
                            echo \kartik\date\DatePicker::widget([
                                'name' => 'payment_date',
                                'value' => $model->order_date,
                                'options' => [
                                    // 'readonly' => true,
                                ],
                                'pluginOptions' => [
                                    'format' => 'dd/mm/yyyy',
                                    'todayHighlight' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-lg-6">
                            <div class="label">เวลา</div>
                            <?php
                            echo \kartik\time\TimePicker::widget([
                                'name' => 'payment_time',
                                'options' => [
                                    //'readonly' => true,
                                ],
                                'pluginOptions' => [
                                    'showSeconds' => false,
                                    'showMeridian' => false,
                                    'minuteStep' => 1,
                                    'secondStep' => 5,
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-striped table-bordered table-payment-list">
                                <thead>
                                <tr>
                                    <th>รหัสลูกค้า</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>ยอดขาย</th>
                                    <th>วิธีชำระเงิน</th>
                                    <th>เงื่อนไข</th>
                                    <th>ยอดชำระ</th>
                                    <th>คงค้าง</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-success btn-payment-submit" data-dismiss="modalx"><i
                                class="fa fa-check"></i> ตกลง
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="editpaymentModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <form id="form-edit-payment" action="<?= \yii\helpers\Url::to(['orders/updatepayment'], true) ?>" method="post">
            <input type="hidden" class="payment-order-update-id" name="payment_order_id" value="">
            <input type="hidden" class="payment-remove-list" name="payment_remove_list" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row" style="width: 100%">
                        <div class="col-lg-11">
                            <h2 style="color: #255985"><i class="fa fa-coins"></i> ประวัติการชำระเงิน</h2>
                        </div>
                        <div class="col-lg-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h3>เลขที่ใบขาย <span class="text-order-no"
                                                  style="color: #e0a800"><?= $model->order_no; ?></span></h3>
                        </div>
                        <div class="col-lg-6" style="border-left: 1px dashed gray">
                            <h3>ลูกค้า <span class="text-customer-info"
                                             style="color: #e0a800"></span></h3>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-striped table-bordered table-payment-trans-list" width="100%">
                                <thead>
                                <tr>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">วิธีชำระเงิน</th>
                                    <th style="text-align: center">เงื่อนไขชำระเงิน</th>
                                    <th style="text-align: center;width: 15%">จำนวนเงิน</th>
                                    <th style="text-align: center">-</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-success btn-update-paymet-submit"
                            data-dismiss="modalx"><i
                                class="fa fa-check"></i> ตกลง
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="transferModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <form id="form-transfer" action="<?= \yii\helpers\Url::to(['orders/addtransfer'], true) ?>" method="post">
            <input type="hidden" class="transfer-order-id" name="transfer_order_id" value="<?= $model->id ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row" style="width: 100%">
                        <div class="col-lg-11">
                            <h2 style="color: #255985"><i class="fa fa-truck-loading"></i> บันทึกโอนย้ายสินค้าระหว่างทาง
                            </h2>
                        </div>
                        <div class="col-lg-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>

                </div>
                <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
                <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="label">โอนย้ายไปยังใบขายเลขที่</div>
                            <?php
                            echo \kartik\select2\Select2::widget([
                                'name' => 'order_target',
                                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Orders::find()->where(['status' => 1, 'sale_channel_id' => 1, 'company_id'=>$company_id,'branch_id'=>$branch_id])->all(), 'id', function ($data) {
                                    return $data->order_no . ' (' . \backend\models\Deliveryroute::findName($data->order_channel_id) . ')';
                                })
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-lg-12">
                            <table class="table table-striped table-bordered table-transfer-list">
                                <thead>
                                <tr>
                                    <th>รหัสสินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>ราคาขาย</th>
                                    <th>จำนวนทั้งหมด</th>
                                    <!--                                    <th>สายส่ง</th>-->
                                    <th>จำนวนโอนย้าย</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-success btn-transfer-submit" data-dismiss="modalx"><i
                                class="fa fa-check"></i> ตกลง
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="transferIssueModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <form id="form-transfer-sale" action="<?= \yii\helpers\Url::to(['orders/savetransfersale'], true) ?>"
              method="post">
            <input type="hidden" class="order-id" name="order_id" value="<?= $model->id ?>">
            <input type="hidden" class="transfer-order-id" name="transfer_order_id" value="0">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row" style="width: 100%">
                        <div class="col-lg-11">
                            <h2 style="color: #255985"><i class="fa fa-cart-arrow-down"></i> บันทึกขายสินค้ารับโอน
                            </h2>
                        </div>
                        <div class="col-lg-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>

                </div>
                <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
                <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->

                <div class="modal-body">
                    <table class="table table-bordered table-striped table-transfer-sale-list">
                        <thead>
                        <tr>
                            <th>สินค้า</th>
                            <th style="width: 15%">จำนวนคงคลัง</th>
                            <th>ลูกค้า</th>
                            <th>จำนวนขาย</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-success btn-transfer-sale-submit" data-dismiss="modalx"><i
                                class="fa fa-check"></i> ตกลง
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
$url_to_find_item = \yii\helpers\Url::to(['pricegroup/productdata'], true);
$url_to_get_sale_item = \yii\helpers\Url::to(['orders/find-saledata'], true);
$url_to_get_price_group = \yii\helpers\Url::to(['orders/find-pricegroup'], true);
$url_to_get_car_item = \yii\helpers\Url::to(['orders/find-car-data'], true);
$url_to_get_issue_item = \yii\helpers\Url::to(['orders/find-issue-data'], true);
$url_to_get_issue_detail = \yii\helpers\Url::to(['orders/find-issue-detail'], true);
$url_to_get_sale_item_update = \yii\helpers\Url::to(['orders/find-saledata-update'], true);
$url_to_get_car_emp = \yii\helpers\Url::to(['orders/findcarempdaily'], true);
$url_to_get_term_item = \yii\helpers\Url::to(['orders/find-term-data'], true);
$url_to_get_payment_list = \yii\helpers\Url::to(['orders/find-payment-list'], true);
$url_to_get_condition = \yii\helpers\Url::to(['orders/getpaycondition'], true);
$url_to_get_payment_trans = \yii\helpers\Url::to(['orders/getpaytrans2'], true);
$url_to_get_transfer_sale_item = \yii\helpers\Url::to(['orders/gettransfer-sale-item'], true);
$url_to_register_issue = \yii\helpers\Url::to(['orders/registerissue'], true);
$js = <<<JS
  var removelist = [];
  var selecteditem = [];
  var checkeditem = [];
  var current_row = 0;
  var payment_remove_list = [];
  
  var tableOffset = null;
  var headerx = null;
  var fixedHeader = null;
  
  $(function(){
      // $(window).bind("scroll", function() {
      //    // alert(tableOffset);
      //       var offset = $(this).scrollTop();
      // 
      //       if (offset >= tableOffset && fixedHeader.is(":hidden")) {
      //           fixedHeader.show();
      //       }
      //       else if (offset < tableOffset) {
      //           fixedHeader.hide();
      //       }
      //   });
      
     $("#order-date").datepicker({
       'format':'dd/mm/yyyy'
     });
     
     $(".line_qty,.line_price").on("keypress", function (event) {
            $(this).val($(this).val().replace(/[^0-9\.]/g, ""));
            if ((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
     });

     var page_status = $(".page-status").val();
     if(page_status == 1){
         var ids = $(".page-status").attr("data-var");
         order_update_data(ids);
     }
    // cal_all();
     
     $(".btn-payment").click(function(){
          var ids = $(".current_id").val();
          var price_group = $(".current-price-group").val();
          //alert(checkeditem.length);
          if(checkeditem.length > 0 && ids >0){
              $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_payment_list",
              'data': {'order_id': checkeditem, 'id': ids, 'price_group_id': price_group},
              'success': function(data) {
                  //  alert(data);
                   $(".table-payment-list tbody").html(data);
                  $("#paymentModal").modal("show"); 
                 }
              });
          }
     });
     
     $(".btn-paymet-submit").click(function(){
        if(confirm('คุณมันใจที่จะทำรายการนี้ใช่หรือไม่ ?')){
            $("form#form-payment").submit();
        } 
     });
     
     $(".btn-payment-submit").click(function(){
        if(confirm('คุณมันใจที่จะทำรายการนี้ใช่หรือไม่ ?')){
            $("form#form-order-payment").submit();
        } 
     });
     
      $(".btn-transfer-submit").click(function(){
        if(confirm('คุณมันใจที่จะทำรายการนี้ใช่หรือไม่ ?')){
            $("form#form-transfer").submit();
        } 
     });
     
     checktabs();
     
  });
  
  function checktabs(){
      $("a.cur-tab").each(function(){
         if($(this).hasClass('active')){
             $(this).trigger('click');
         } 
         
     });
  }
  
 function getCondition(e){
     var ids = e.val();
     if(ids){
         //alert(ids);
         $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_condition",
              'data': {'id': ids},
              'success': function(data) {
                   e.closest('tr').find(".select-condition").html(data);
                //   alert(e.closest('tr').find('.line-customer-id').val());
              }
         });
     }
 }
 function route_change(e) {
        //var url_to_show_customer = $(".url-customer").attr('data-url');
          //$.post(url_to_show_customer + "&id=" + e.val(), function (data) {
            //$("select#customer-id").html(data);
           // $("select#customer-id").prop("disabled", "");
           //alert(data);
           //  $("#table-sale-list tbody").html(data);
         //});
        // alert(e.val());
         $(".text-car-emp").html("");
         $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_price_group",
              'data': {'route_id': e.val()},
              'success': function(data) {
                  $(".list-detail").html(data);
                     
              }
         });
         
//          $.ajax({
//              'type':'post',
//              'dataType': 'html',
//              'async': false,
//              'url': "$url_to_get_sale_item",
//              'data': {'id': e.val()},
//              'success': function(data) {
//                  $("#table-sale-list").html(data);
//              }
//         });

         $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_car_item",
              'data': {'id': e.val()},
              'success': function(data) {
                 // alert();
                 $("#car-ref-id").html(data);
                 $("#car-ref-id").prop("disabled","");
                 $("#issue-id").prop("disabled","");
              }
         });
         
         $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_issue_item",
              'data': {'id': e.val()},
              'success': function(data) {
                 // alert();
                 $("#issue-id").html(data);
                 $("#issue-id").prop("disabled","");
              }
         });
         
         
         

            // tableOffset = $('table[id^="table-sale-list"]').offset().top;
            // headerx = $('table[id^="table-sale-list"] > thead').clone();
            // fixedHeader = $('table[id^="table-sale-list"]').append(headerx);
                       
           //alert(headerx);
         
 }
 
 function getPaymentterm(e){
     $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_term_item",
              'data': {'id': e.val()},
              'success': function(data) {
                 // alert();
                 $("#payment-term-id").html(data);
                // $("#car-ref-id").prop("disabled","");
              }
         });
 }

 function removeorderline(e){
     //var cust_line_id = e.closest('tr').find('.line-customer-id').val();
    var recid = e.attr("data-var");
     if(recid > 0){
         //alert(recid);
         removelist.push(recid);
         e.parent().parent().remove();
     }
     $(".remove-list").val(removelist);
     cal_all2();
 }

 function order_update_data(ids) {
     if(ids !='' || ids > 0){
               $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_sale_item_update",
              'data': {'id': ids},
              'success': function(data) {
                  //alert(data);
                  $(".list-detail").html(data);
              }
         });
     }
     cal_all2();
 }

 function line_qty_cal(e){
      var row = e.parent().parent();
      var line_price = e.attr('data-var');
      var line_onhand = e.closest("tr").find(".line-product-onhand").val();
      
      //alert(line_onhand);
    
      var line_total = 0;
      var line_sale_price_total = 0;
      row.find(':input[type=number]').each(function(){
         var qty = parseFloat($(this).val());
        var price = $(this).attr('data-var');
       //  var price = line_price;
         
         var xqty = 0;
        // alert(qty);
         if(!isNaN(qty)){
             xqty = qty;
         }
         // alert(xqty);
         // alert(price);
         line_total = parseFloat(line_total) + xqty;
         line_sale_price_total = parseFloat(line_sale_price_total) + (xqty * price);
      });
     // alert(e.val());
      if(e.val()>0){
           e.css('background-color', '#33CC00');
           e.css('color', 'black');
      }else{
           e.css('background-color', 'white');
           e.css('color', 'black');
      }
      e.closest("tr").find(".line-qty-cal").val(line_total);
      e.closest("tr").find(".line-total-price").val(line_sale_price_total);
      e.closest("tr").find(".line-total-price-cal").val(line_sale_price_total);

      cal_all2();
 }
 
 function cal_all2() {
       var totalall = 0;
       $("table tbody > tr").each(function () {
           var linetotal = $(this).closest("tr").find(".line-total-price-cal").val();
           if (linetotal == '' || isNaN(linetotal)) {
               linetotal = 0;
           }
           totalall = parseFloat(totalall) + parseFloat(linetotal);
       });
       
       $("#order-total-amt").val(parseFloat(totalall).toFixed(0));
       $("#order-total-amt-text").val(addCommas(parseFloat(totalall).toFixed(0)));
 }

 function cal_all() {
       var totalall = 0;
       $("#table-sale-list tr").each(function () {
           var linetotal = $(this).closest("tr").find(".line-total-price-cal").val();
           if (linetotal == '' || isNaN(linetotal)) {
               linetotal = 0;
           }
           totalall = parseFloat(totalall) + parseFloat(linetotal);
       });

       $("#order-total-amt").val(parseFloat(totalall).toFixed(0));
       $("#order-total-amt-text").val(addCommas(parseFloat(totalall).toFixed(0)));
 }

 function getcaremp(e){
   var ids = e.val();
   var trans_date = $("#order-date").val();
   //alert(trans_date);
   if(ids){
               $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_car_emp",
              'data': {'id': ids,'order_date': trans_date},
              'success': function(data) {
                  // alert(data);
                  if(data == ''){
                      $(".text-car-emp").removeClass('badge-info');
                      $(".text-car-emp").addClass('badge-danger');
                      $(".text-car-emp").html('ไม่พบรายชื่อพนักงาน');
                  }else{
                      $(".text-car-emp").html(data);
                      //$(".text-car-emp").html(data[0]['html']);
                  }
              }
         });
               
               //$("form#order-form").submit();
   }
 }
 
   function updatetab(e){
     checkeditem = [];
     var ids = e.attr('data-var');
     $(".current-price-group").val(ids);
   }
   
   function showselectpayment(e){
        var table_id = e.parent().parent().parent().parent().attr('id');
        var cnt = 0;
        var cnt_selected = 0;
        var cur_id = e.attr('data-var');
       //alert(table_id);
        if(typeof(table_id) != 'undefined'){
               var all_checkbox = $("#"+table_id+ " tbody input[type=checkbox]").length;
               var cnt_selected = $("#"+table_id+" tbody input:checked").length;
               if(all_checkbox == cnt_selected){
                   $(".selected-all-item").prop('checked',true);
                   $("#"+table_id+ " tbody input[type=checkbox]").each(function(){
                      $(this).prop('checked',true);
                   //   checkeditem.push($(this).attr('data-var'));
                   });
               }else{
                   // $(".selected-all-item").prop('checked',false);
                   // $("#"+table_id+ " tbody input[type=checkbox]").each(function(){
                   //    $(this).prop('checked',false);
                   //    var index = checkeditem.indexOf($(this).attr('data-var'));
                   //    if (index !== -1) {
                   //        checkeditem.splice(index, 1);
                   //    }
                   // });
               }
               
               if(cnt_selected > 0){
                 $('.count-selected').html("["+cnt_selected+"] ");   
               }else{
                 $('.count-selected').html("");   
               }
               
               console.log(checkeditem);
               checkeditem = [];
               $("#"+table_id+ " tbody input[type=checkbox]").each(function(){
                    if(this.checked){
                       // if(cur_id != $(this).attr('data-var')){
                          //   alert($(this).attr('data-var'));
                            checkeditem.push($(this).attr('data-var'));
                       // }
                    }else{
                        // var index = checkeditem.indexOf($(this).attr('data-var'));
                        // if (index !== -1) {
                        //     checkeditem.splice(index, 1);
                        // }
                    }
                          
                });
           $('.btn-payment').show();
        }
        
    }
    
    function showselectpaymentall(e){
        var table_id = e.parent().parent().parent().parent().attr('id');
        var cnt = 0;
        var cnt_selected = 0;
        if(typeof(table_id) != 'undefined'){
            var all_checkbox = $("#"+table_id+ " tbody input[type=checkbox]").length;
            var cnt_selected = $("#"+table_id+" tbody input:checked").length;
            if(cnt_selected > 0){
                if(all_checkbox != cnt_selected){
                    //alert();
                     $("#"+table_id+ " tbody input[type=checkbox]").each(function(){
                        $(this).prop('checked',true);
                     });
                }else{
                     $("#"+table_id+ " tbody input[type=checkbox]").each(function(){
                        $(this).prop('checked',false);
                     });
                }
               
            }else{
                $("#"+table_id+ " tbody input[type=checkbox]").each(function(){
                      $(this).prop('checked',true);
                });
            }
        }
        
        $("#"+table_id+ " tbody input[type=checkbox]").each(function(){
            if(this.checked){
                // alert($(this).attr('data-var'));
                checkeditem.push($(this).attr('data-var'));
            }else{
                var index = checkeditem.indexOf($(this).attr('data-var'));
                if (index !== -1) {
                    checkeditem.splice(index, 1);
                }
            }
                  
        });
        
        if(checkeditem.length > 0){
            $('.count-selected').html("["+checkeditem.length+"] ");
            $('.btn-payment').show();
        }else{
            $('.count-selected').html("");   
            $('.btn-payment').hide();
        }
        
    }
 
function showeditpayment(e){
      var order_id = e.attr('data-id');
      var customer_id = e.attr('data-var');
        // alert(order_id);
        // alert(customer_id);
      if(order_id > 0 && customer_id > 0){
          
              $.ajax({
              'type':'post',
              'dataType': 'json',
              'async': false,
              'url': "$url_to_get_payment_trans",
              'data': {'order_id': order_id, 'customer_id': customer_id},
              'success': function(data) {
                  //  alert(data);
                  if(data.length > 0){
                       $(".payment-order-update-id").val(order_id);
                       $(".text-customer-info").html(data[0]['customer_name']);
                       $(".table-payment-trans-list tbody").html(data[0]['data']);
                       $("#editpaymentModal").modal('show');
                  }
                  
                 }
              });
              
      }
}
function removepayline(e){
      var ids = e.attr('data-id');
      if(ids > 0){
          if(confirm("ต้องการลบรายการนี้ใช่หรือไม่")){
              e.parent().parent().remove();
              payment_remove_list.push(ids);
              //alert(ids);
          }
      }
     $(".payment-remove-list").val(payment_remove_list);
}

function showtransfer(e){
      var issue_id = $("#issue-id").val();
      if(issue_id > 0){
          $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_issue_detail",
              'data': {'issue_id': issue_id},
              'success': function(data) {
                  //  alert(data);
                  if(data != ''){
                      $(".table-transfer-list tbody").html(data);
                      $("#transferModal").modal('show');
                  }
                  
                 }
              });
      }
     
}
function showtransfersale(e){
      var order_id = $(".current_id").val();
      if(order_id > 0){
        //  alert(order_id);
          $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_transfer_sale_item",
              'data': {'order_id': order_id},
              'success': function(data) {
                 //  alert(data);
                  if(data != ''){
                      $(".table-transfer-sale-list tbody").html(data);
                      $("#transferIssueModal").modal('show');
                  }
              },
              'error': function(err){
                  alert('Data error');
              }
                 
              });
      }
     
}

function issueqtychange(e){
      var a_qty = e.closest('tr').find('.line-issue-qty').val();
      var t_qty = e.val();
      if(parseFloat(t_qty) > parseFloat(a_qty)){
          alert('จำนวนเบิกมากกว่าจำนวนที่ใช้ได้');
          e.val(a_qty);
          return false;
      }
}

function transfersaleqtychange(e){
      var a_qty = e.closest('tr').find('.line-transfer-issue-qty').val();
      var t_qty = e.val();
      if(parseFloat(t_qty) > parseFloat(a_qty)){
          alert('จำนวนขายมากกว่าจำนวนที่ใช้ได้');
          e.val(a_qty);
          return false;
      }
}

function addIssueorder(e){
    //  alert(e.val());
      var order_id = $(".current_id").val();
      if(e.val() != '' && order_id != null)
      {
            $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_register_issue",
              'data': {'order_id': order_id,'issue_list': e.val()},
              'success': function(data) {
                // alert(data);
                $("form#order-form").submit();
              },
              'error': function(err){
                  alert('Data error');
              }
                 
            });  
      }
      
}

function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
 }
JS;
$this->registerJs($js, static::POS_END);
?>
