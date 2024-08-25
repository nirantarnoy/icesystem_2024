<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Assetrental */
/* @var $form yii\widgets\ActiveForm */

$use_total_count = 0;
$not_use_total_count = 0;
$total_amount = 0;
?>

    <div class="assetrental-form">

        <?php $form = ActiveForm::begin(); ?>
        <input type="hidden" class="remove-list" name="removelist" value="">
        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'journal_no')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'trans_date')->widget(\kartik\date\DatePicker::className(),
                    [
                        'pluginOptions' => ['format' => 'dd-mm-yyyy']]
                ) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'work_name')->textInput(['maxlength' => true,]) ?>
            </div>
            <div class="col-lg-3">
                <?php $model->use_from = $model->isNewRecord ? date('Y-m-d') : date('Y-m-d',strtotime($model->use_from)); ?>
                <?= $form->field($model, 'use_from')->widget(\kartik\date\DatePicker::className(),
                    [
                            'options' => [
                                    'format' => 'dd-mm-yyyy',
                            ]
                    ]
                ) ?>
            </div>
            <div class="col-lg-3">
                <?php $model->use_to = $model->isNewRecord ? date('Y-m-d') : date('Y-m-d',strtotime($model->use_to)); ?>
                <?= $form->field($model, 'use_to')->widget(\kartik\date\DatePicker::className(),
                    [
                        'options' => [
                            'format' => 'dd-mm-yyyy',
                        ]
                    ]
                ) ?>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <h3>รายการถัง</h3>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-9">
                <div class="btn btn-outline-primary" onclick="selectallcash();">เลือกใช้งานทั้งหมด</div>
                <div class="btn btn-outline-primary" onclick="selectallbank();">เลือกคืนทั้งหมด</div>
            </div>
            <div class="col-lg-3" style="text-align: right">

            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-striped" id="table-list">
                    <thead>
                    <tr>
                        <th style="text-align: center;width: 5%">#</th>
                        <th>ขนาดถัง</th>
                        <th>รหัสถัง</th>
                        <th>ราคา</th>
                        <th style="text-align: center">สถานะใช้งาน</th>
                        <th style="text-align: center">สถานะคืนถัง</th>
                        <th>-</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($model->isNewRecord): ?>
                        <tr>
                            <td style="text-align: center;"></td>
                            <td>
                                <input type="text" class="form-control line-size" name="line_size[]" readonly>
                            </td>
                            <td>
                                <input type="hidden" class="form-control line-asset-id" name="line_asset_id[]" readonly>
                                <input type="text" class="form-control line-asset-code" name="line_asset_code[]"
                                       readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control line-price" name="line_price[]" readonly>
                                <input type="hidden" class="line-use-status" name="line_use_status[]" value="0">
                            </td>
                            <td style="text-align: center;">
                                <div class="btn-group">
                                    <div class="btn btn-success line-use-check" data-var="1"
                                         onclick="checkpaytype2($(this))">ใช้งาน
                                    </div>
                                    <div class="btn btn-default line-no-use-check" data-var="0"
                                         onclick="checkpaytype3($(this))">ไม่ใช้งาน
                                    </div>

                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div class="btn-group">
                                    <div class="btn btn-success line-return-check" data-var="1"
                                         onclick="checkpaytype4($(this))">คืน
                                    </div>
                                    <div class="btn btn-default line-no-return-check" data-var="0"
                                         onclick="checkpaytype5($(this))">ไม่คืน
                                    </div>

                                </div>
                            </td>
                            <td style="text-align: center">
                                <div class="btn btn-sm btn-danger" onclick="removeline($(this))">ลบ</div>
                                <input type="hidden" class="line-return-status" name="line_return_status[]" value="0">
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php if ($model_line != null): ?>
                            <?php $line_no = 0; ?>
                            <?php foreach ($model_line as $value): ?>
                                <?php
                                $css_btn_use_check = 'btn-default';
                                $css_btn_not_use_check = 'btn-default';
                                $css_btn_return_check = 'btn-default';
                                $css_btn_not_return_check = 'btn-default';

                                if ($value->use_status == 1) {
                                    $css_btn_use_check = 'btn-success';
                                    $css_btn_not_use_check = 'btn-default';
                                } else {
                                    $css_btn_use_check = 'btn-default';
                                    $css_btn_not_use_check = 'btn-danger';
                                }
                                if ($value->return_status == 1) {
                                    $css_btn_return_check = 'btn-success';
                                    $css_btn_not_return_check = 'btn-default';
                                } else {
                                    $css_btn_return_check = 'btn-default';
                                    $css_btn_not_return_check = 'btn-danger';
                                }

                                if ($value->use_status == 1) {
                                    $use_total_count += 1;
                                    $total_amount += $value->price;
                                }
                                if ($value->use_status == 0) {
                                    $not_use_total_count += 1;
                                }



                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $line_no += 1; ?></td>
                                    <td>
                                        <input type="text" class="form-control line-size" name="line_size[]"
                                               value="<?= $value->remark ?>" readonly>
                                    </td>
                                    <td>
                                        <input type="hidden" class="form-control line-asset-id" name="line_asset_id[]"
                                               value="<?= $value->asset_id ?>" readonly>
                                        <input type="text" class="form-control line-asset-code" name="line_asset_code[]"
                                               value="<?= \backend\models\Assetsitem::findCode($value->asset_id) ?>"
                                               readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control line-price" name="line_price[]"
                                               value="<?= $value->price ?>" readonly>
                                        <input type="hidden" class="line-use-status" name="line_use_status[]"
                                               value="<?= $value->use_status ?>">
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="btn-group">
                                            <div class="btn <?= $css_btn_use_check ?> line-use-check" data-var="1"
                                                 onclick="checkpaytype2($(this))">ใช้งาน
                                            </div>
                                            <div class="btn <?= $css_btn_not_use_check ?> line-no-use-check"
                                                 data-var="0"
                                                 onclick="checkpaytype3($(this))">ไม่ใช้งาน
                                            </div>

                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="btn-group">
                                            <div class="btn <?= $css_btn_return_check ?> line-return-check" data-var="1"
                                                 onclick="checkpaytype4($(this))">คืน
                                            </div>
                                            <div class="btn <?= $css_btn_not_return_check ?> line-no-return-check"
                                                 data-var="0"
                                                 onclick="checkpaytype5($(this))">ไม่คืน
                                            </div>

                                        </div>
                                    </td>
                                    <td style="text-align: center">
                                        <div class="btn btn-sm btn-danger" data-var="<?=$value->id?>" onclick="removeline($(this))">ลบ</div>
                                        <input type="hidden" class="line-return-status" name="line_return_status[]"
                                               value="<?= $value->return_status ?>">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                            <div class="btn btn-sm btn-primary" onclick="showfindasset($(this))">เลือกถัง</div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-3"><h4 style="color: green;">ใช้งาน <span
                            style="color: black;"><?= number_format($use_total_count, 0) ?></span> ใบ</h4></div>
            <div class="col-lg-3"><h4 style="color: red;">ไม่ใช้งาน <span
                            style="color: black;"><?= number_format($not_use_total_count, 0) ?></span> ใบ</h4></div>
            <div class="col-lg-3"><h4>รวมเงิน <span><?= number_format($total_amount, 2) ?></span></h4></div>
            <div class="col-lg-3"></div>
        </div>
        <?php
        $asset_by_group = creategroup($model->id);
        ?>
        <?php if ($asset_by_group != null): ?>
        <table style="width: 50%">
            <tr>
                <td style="text-align: center;width: 10%"><b>ขนาด</b></td>
                <td style="text-align: right;width: 10%"><b>จำนวน</b></td>
                <td style="text-align: center;width: 5%"></td>
                <td style="text-align: right;right: 10%"><b>จำนวนเงิน</b></td>
            </tr>
            <?php for ($g = 0; $g < count($asset_by_group); $g++): ?>
            <tr>
                <td  style="text-align: center;width: 10%"><?=$asset_by_group[$g]['code'] ?></td>
                <td  style="text-align: right;width: 10%"><?= number_format($asset_by_group[$g]['qty'], 0) ?></td>
                <td  style="text-align: center;width: 5%">ใบ</td>
                <td  style="text-align: right;width: 10%"><?= number_format($asset_by_group[$g]['total_amount'], 2) ?></td>
            </tr>
            <?php endfor; ?>
        </table>
        <?php endif; ?>

        <br/>
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <div class="col-lg-3"></div>
            <div class="col-lg-3"></div>
            <div class="col-lg-3" style="text-align: right;">
                <a href="index.php?r=assetrental/print&id=<?= $model->id ?>" class="btn btn-warning">พิมพ์</a>
            </div>
        </div>


        <?php ActiveForm::end(); ?>

    </div>


    <div id="findModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <b>ค้นหาถัง <span class="checkseleted"></span></b>
                        </div>
                    </div>
                </div>
                <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
                <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->

                <div class="modal-body">
                    <div class="row" style="width: 100%">
                        <div class="col-lg-3">
                            <input type="text" class="form-control find-asset" name="find_asset" value=""
                                   placeholder="ค้นหาถัง">
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-primary btn-search-submit">
                                <span class="fa fa-search"></span>
                            </button>
                        </div>
                        <div class="col-lg-2">
                            <!--                        <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="text-align: right">
                            <button class="btn btn-outline-success btn-emp-selected" data-dismiss="modalx" disabled><i
                                        class="fa fa-check"></i> ตกลง
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                        class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                            </button>
                        </div>
                    </div>
                    <div style="height: 10px;"></div>
                    <input type="hidden" name="line_qc_product" class="line_qc_product" value="">
                    <table class="table table-bordered table-striped table-find-list" width="100%">
                        <thead>
                        <tr>
                            <th style="text-align: center">เลือก</th>
                            <th>ขนาดถัง</th>
                            <th>รหัสถัง</th>

                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-success btn-emp-selected" data-dismiss="modalx" disabled><i
                                class="fa fa-check"></i> ตกลง
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                    </button>
                </div>
            </div>

        </div>
    </div>
    <br/>
<?php
function creategroup($model_id)
{
    $data = [];
    if ($model_id) {
        $sql = "SELECT t1.remark,SUM(t1.price) as amount,COUNT(t1.id) as qty  from asset_rental_line as t1 WHERE t1.asset_rental_id =" . $model_id;
        $sql .= " AND t1.use_status=1";
        $sql .= " GROUP BY t1.remark";
        $sql .= " ORDER BY t1.remark";
        $query = \Yii::$app->db->createCommand($sql);
        $model = $query->queryAll();
        if ($model) {
            for ($i = 0; $i <= count($model) - 1; $i++) {
                array_push($data, [
                    'code' => $model[$i]['remark'],
                    'qty' => $model[$i]['qty'],
                    'total_amount' => $model[$i]['amount'],
                ]);
            }
        }
    }
    return $data;
}

?>
<?php
$url_to_find_asset = \yii\helpers\Url::to(['assetrental/findasset'], true);

$js = <<<JS
var selecteditem = [];
var removelist = [];
$(function(){
    $(".btn-emp-selected").click(function () {
        var linenum = 0;
        var line_count = 0;
        var emp_qty = $(".selected-emp-qty").val();
        //alert(emp_qty);
        
        $("#table-list tbody tr").each(function () {
            if($(this).closest('tr').find('.line-car-emp-code').val()  != ''){
                // alert($(this).closest('tr').find('.line-car-emp-code').val());
             line_count += 1;   
            }
        });
      // alert(selecteditem.length + line_count);
      // alert(emp_qty);
       // if((line_count + selecteditem.length ) > emp_qty){
       // if((line_count + selecteditem.length ) > 2){
       //      alert('จำนวนพนักงานเกินกว่าที่กำหนด');
       //      return false;
       //  }
        
        
        if (selecteditem.length > 0) {
            for (var i = 0; i <= selecteditem.length - 1; i++) {
                var asset_id = selecteditem[i]['id'];
                var asset_code = selecteditem[i]['code'];
                var asset_size = selecteditem[i]['asset_size'];
                var asset_rent_price = selecteditem[i]['asset_rent_price'];
               // alert(asset_code);
                //alert(line_prod_id);
                if(check_dup(asset_id) == 1){
                        alert("มีรายการ " +asset_code+ " ในรายการแล้ว");
                        return false;
                }
                
                var tr = $("#table-list tbody tr:last");
                
                if (tr.closest("tr").find(".line-asset-id").val() == "") {
                  //  alert(line_prod_code);
                    tr.closest("tr").find(".line-asset-id").val(asset_id);
                    tr.closest("tr").find(".line-asset-code").val(asset_code);
                    tr.closest("tr").find(".line-size").val(asset_size);
                    tr.closest("tr").find(".line-price").val(asset_rent_price);
                    //console.log(line_prod_code);
                } else {
                    var clone = tr.clone();
                    //clone.find(":text").val("");
                    // clone.find("td:eq(1)").text("");
                    clone.closest("tr").find(".line-asset-id").val(asset_id);
                    clone.closest("tr").find(".line-asset-code").val(asset_code);
                    clone.closest("tr").find(".line-size").val(asset_size);
                    clone.closest("tr").find(".line-price").val(asset_rent_price);
                    tr.after(clone);
                    //cal_num();
                }
            }
            
        //  cal_num();
        }
      
        selecteditem = [];
      

        $("#table-find-list tbody tr").each(function () {
            $(this).closest("tr").find(".btn-line-select").removeClass('btn-success');
            $(this).closest("tr").find(".btn-line-select").addClass('btn-outline-success');
        });
        
       
        
        $(".btn-emp-selected").removeClass('btn-success');
        $(".btn-emp-selected").addClass('btn-outline-success');
        $("#findModal").modal('hide');
    });
    
     $(".btn-search-submit").click(function(){
       var find_price = $(".find-asset").val();
        $.ajax({
          type: 'post',
          dataType: 'html',
          url:'$url_to_find_asset',
          async: false,
          data: {'find_asset':find_price},
          success: function(data){
            //  alert(data);
              $(".table-find-list tbody").html(data);
          },
          error: function(err){
              alert(err);
          }
          
        });
    
   });
});
function check_dup(asset_id){
    var res = 0;
    if(asset_id > 0){
       $("#table-list tbody tr").each(function(){
           if($(this).closest('tr').find('.line-asset-id').val() == asset_id){
               res = 1;
           }
       });
    }
    return res;
}
// function selectallcash(){
//     $(".table-list tbody tr").each(function(){
//         $(this).closest('tr').find('.line-payment-type').val(0);
//         $(this).closest('tr').find('.line-pay-bank').removeClass('btn-success');
//         $(this).closest('tr').find('.line-pay-bank').addClass('btn-default');
//         $(this).closest('tr').find('.line-pay-cash').removeClass('btn-default');
//         $(this).closest('tr').find('.line-pay-cash').addClass('btn-success');
//     });
// }
// function selectallbank(){
//     $(".table-list tbody tr").each(function(){
//         $(this).closest('tr').find('.line-payment-type').val(1);
//         $(this).closest('tr').find('.line-pay-cash').removeClass('btn-success');
//         $(this).closest('tr').find('.line-pay-cash').addClass('btn-default');
//         $(this).closest('tr').find('.line-pay-bank').removeClass('btn-default');
//         $(this).closest('tr').find('.line-pay-bank').addClass('btn-success');
//     });
// }

function checkpaytype2(e){
    var val = e.attr('data-var');
        e.closest('tr').find('.line-use-status').val(val);
        e.closest('tr').find('.line-no-use-check').removeClass('btn-danger');
        e.closest('tr').find('.line-no-use-check').addClass('btn-default');
        e.removeClass('btn-default');
        e.addClass('btn-success');
}
function checkpaytype3(e){
    var val = e.attr('data-var');
        e.closest('tr').find('.line-use-status').val(val);
        e.closest('tr').find('.line-use-check').removeClass('btn-success');
        e.closest('tr').find('.line-use-check').addClass('btn-default');
        e.removeClass('btn-default');
        e.addClass('btn-danger');
}
function checkpaytype4(e){
    var val = e.attr('data-var');
        e.closest('tr').find('.line-return-status').val(val);
        e.closest('tr').find('.line-no-return-check').removeClass('btn-danger');
        e.closest('tr').find('.line-no-return-check').addClass('btn-default');
        e.removeClass('btn-default');
        e.addClass('btn-success');
}
function checkpaytype5(e){
    var val = e.attr('data-var');
        e.closest('tr').find('.line-return-status').val(val);
        e.closest('tr').find('.line-return-check').removeClass('btn-success');
        e.closest('tr').find('.line-return-check').addClass('btn-default');
        e.removeClass('btn-default');
        e.addClass('btn-danger');
}

function selectallcash(){
    $("#table-list tbody tr").each(function(){
        $(this).closest('tr').find('.line-use-status').val(1);
        $(this).closest('tr').find('.line-no-use-check').removeClass('btn-danger');
        $(this).closest('tr').find('.line-no-use-check').addClass('btn-default');
        $(this).closest('tr').find('.line-use-check').removeClass('btn-default');
        $(this).closest('tr').find('.line-use-check').addClass('btn-success');
    });
}
function selectallbank(){
    $("#table-list tbody tr").each(function(){
        $(this).closest('tr').find('.line-return-status').val(1);
        $(this).closest('tr').find('.line-no-return-check').removeClass('btn-danger');
        $(this).closest('tr').find('.line-no-return-check').addClass('btn-default');
        $(this).closest('tr').find('.line-return-check').removeClass('btn-default');
        $(this).closest('tr').find('.line-return-check').addClass('btn-success');
    });
}

function showfindasset(e){
    //var customer_id = $('.selected-customer-id').val();
  // alert(customer_id);
    $.ajax({
      type: 'post',
      dataType: 'html',
      url:'$url_to_find_asset',
      async: false,
      data: {'customer_id': ''},
      success: function(data){
       //   alert(data);
          $(".table-find-list tbody").html(data);
          $("#findModal").modal("show");
      },
      error: function(err){
          alert(err);
      }
      
    });
}
function addselecteditem(e) {
        var id = e.attr('data-var');
        var asset_id = e.closest('tr').find('.line-find-asset-id').val();
        var asset_code = e.closest('tr').find('.line-find-asset-code').val();
        var asset_size = e.closest('tr').find('.line-find-asset-size').val();
        var asset_rent_price = e.closest('tr').find('.line-find-asset-price').val();
        ///////
        if (id) {
            //alert(asset_rent_price);
            if(selecteditem!=null){
                $.each(selecteditem, function (i, el) {
                    if (this.id == id) {
                        alert("คุณได้ทำการเลือกรหัสถังนี้ไปแล้ว");
                        return false;
                    }
                });
            }
            // if(checkhasempdaily(id)){
            //     alert("คุณได้ทำการจัดรถให้พนักงานคนนี้ไปแล้ว");
            //     return false;
            // }
            if (e.hasClass('btn-outline-success')) {
                var obj = {};
                obj['id'] = asset_id;
                obj['code'] = asset_code;
                obj['asset_size'] = asset_size;
                obj['asset_rent_price'] = asset_rent_price;
                
               // alert("OKKK" + asset_code);
               
                selecteditem.push(obj);
                
                e.removeClass('btn-outline-success');
                e.addClass('btn-success');
                disableselectitem();
                console.log(selecteditem);
            } else {
                //selecteditem.pop(id);
                $.each(selecteditem, function (i, el) {
                    if (this.id == id) {
                        selecteditem.splice(i, 1);
                    }
                });
                e.removeClass('btn-success');
                e.addClass('btn-outline-success');
                
                disableselectitem();
                console.log(selecteditem);
              
            }
        }
        
}
function disableselectitem() {
        if (selecteditem.length > 0) {
            $(".btn-emp-selected").prop("disabled", "");
            $(".btn-emp-selected").removeClass('btn-outline-success');
            $(".btn-emp-selected").addClass('btn-success');
        } else {
            $(".btn-emp-selected").prop("disabled", "disabled");
            $(".btn-emp-selected").removeClass('btn-success');
            $(".btn-emp-selected").addClass('btn-outline-success');
        }
}
function removeline(e){
     
          if(confirm('ต้องการลบรายการนี้ใช่หรือไม่ ?')){
               if($("#table-list tbody tr").length == 1){
                   e.closest("tr").find(".line-asset-id").val('');
                   e.closest("tr").find(".line-asset-code").val('');
                   e.closest("tr").find(".line-size").val('');
                   
                    $(".table-after-list tbody tr").each(function(){
                        $(this).closest("tr").find("td:eq(0)").html('');
                        $(this).closest("tr").find("td:eq(1)").html('');
                        $(this).closest("tr").find("td:eq(2)").html('');
                        $(this).closest("tr").find("td:eq(3)").html('');
                        $(this).closest("tr").find("td:eq(4)").html('');
                        $(this).closest("tr").find(".product-group-line-id").val('');
                    });
                   
                 }else{
                    var recid = e.attr("data-var");
                     if(recid > 0){
                         //alert(recid);
                         removelist.push(recid);
                         e.parent().parent().remove();
                     }
                     $(".remove-list").val(removelist);
                  // e.parent().parent().remove();
               }
               
               var line_order_id = e.closest("tr").find(".line-order-selected-id").val();
               if(line_order_id != ''){
                   var result = line_order_id.split(',');
                   for(var x= 0; x<= result.length -1 ;x++){
                       for(var z=0;z<=selectedorderid.length-1;z++){
                           if(selectedorderid[z] == result[x]){
                                selectedorderid.splice(z, 1);
                           }
                       }
                   }
               }
          }
          
      var linenum = 0;
       $("#table-list tbody tr").each(function () {
            linenum += 1;
       });
       //$(".selected-emp-qty").val(linenum);
}  
JS;

$this->registerJs($js, static::POS_END);
?>