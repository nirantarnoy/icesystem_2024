<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$model_from_com = \backend\models\Company::find()->all();
$model_to_com = \backend\models\Company::find()->all();

?>

<div class="branchtransfer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'journal_no')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg-4">
            <?php $model->trans_date = $model->isNewRecord ? date('d/m/Y') : date('d/m/Y', strtotime($model->trans_date)); ?>
            <?= $form->field($model, 'trans_date')->widget(\kartik\date\DatePicker::className(),
                [
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'todayHighlight' => true
                    ],
                ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-striped" id="table-list">
                <thead>
                <tr>
                    <th>#</th>
                    <th>รหัสสินค้า</th>
                    <th style="text-align: center">จากบริษัท</th>
                    <th style="text-align: center">จากสาขา</th>
                    <th style="text-align: center">จากคลัง</th>
                    <th style="text-align: center">ไปยังบริษัท</th>
                    <th style="text-align: center">ไปยังสาขา</th>
                    <th style="text-align: center">ไปยังคลัง</th>
                    <th style="width: 10%">จำนวน</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td>
                        <input type="text" name="" class="form-control line-product-name" value="" required>
                        <input type="hidden" name="line_product_id[]" class="line-product-id" value="" >
                    </td>
                    <td>
                        <input type="hidden" name="line_from_company[]" class="line-from-company" value="">
                        <input type="text" name="" class="form-control line-from-company-name"
                               style="background-color: #44ab7d;color: white" value="">
                    </td>
                    <td>
                        <input type="hidden" name="line_from_branch[]" class="line-from-branch" value="">
                        <input type="text" name="" class="form-control line-from-branch-name"
                               style="background-color: #44ab7d;color: white" value="">
                    </td>
                    <td>
                        <input type="hidden" name="line_from_warehouse[]" class="line-from-warehouse" value="">
                        <input type="text" name="" class="form-control line-from-warehouse-name"
                               style="background-color: #44ab7d;color: white" value="">

                    </td>
                    <td>
                        <select name="line_to_company[]" class="form-control" id=""
                                style="background-color: #f9a123;color: black;" onchange="getBranch2($(this))">
                            <option value="-1">--เลือก--</option>
                            <?php foreach ($model_from_com as $value): ?>
                                <option value="<?= $value->id ?>"><?= $value->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select name="line_to_branch[]" class="form-control line-select-to-branch" id=""
                                style="background-color: #f9a123;color: black;" onchange="getWarehouse2($(this))">
                            <option value="-1">--เลือก--</option>
                        </select>
                    </td>
                    <td>
                        <select name="line_to_warehouse[]" class="form-control line-select-to-warehouse" id=""
                                style="background-color: #f9a123;color: black;" onchange="whchange($(this))">
                            <option value="-1">--เลือก--</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control line-qty" name="line_qty[]" min="0" value="" disabled>
                    </td>
                    <td>
                        <div class="btn btn-danger btn-sm" onclick="removeline($(this))"><i
                                    class="fa fa-trash"></i></div>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td>
                        <div class="btn btn-primary" onclick="showfind($(this))"><i
                                    class="fa fa-plus-circle"></i></div>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div id="findModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="row" style="width: 100%">
                    <div class="col-lg-11">
                        <h4>เลือกสินค้าสำหรับโอนสาขา</h4>
                        <!--                        <div class="input-group">-->
                        <!--                            <input type="text" class="form-control search-item" placeholder="ค้นหาสินค้า">-->
                        <!--                            <span class="input-group-addon">-->
                        <!--                                        <button type="submit" class="btn btn-primary btn-search-submit">-->
                        <!--                                            <span class="fa fa-search"></span>-->
                        <!--                                        </button>-->
                        <!--                                    </span>-->
                        <!--                        </div>-->
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
                        <select name="search_company[]" class="form-control search-company" id=""
                                style="background-color: #44ab7d;color: white;" onchange="getBranch3($(this))">
                            <option value="-1">--เลือก--</option>
                            <?php foreach ($model_from_com as $value): ?>
                                <option value="<?= $value->id ?>"><?= $value->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <select name="search_branch[]" class="form-control search-branch" id=""
                                style="background-color: #44ab7d;color: white;" onchange="getWarehouse3($(this))">
                            <option value="-1">--เลือก--</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <select name="search_warehouse[]" class="form-control search-warehouse" id=""
                                style="background-color: #44ab7d;color: white;" onchange="getOnhand()">
                            <option value="-1">--เลือก--</option>
                        </select>
                    </div>
                </div>
                <br/>
                <input type="hidden" name="line_qc_product" class="line_qc_product" value="">
                <table class="table table-bordered table-striped table-find-list" width="100%">
                    <thead>
                    <tr>
                        <th style="text-align: center">เลือก</th>
                        <th>รหัสสินค้า</th>
                        <th>รายละเอียด</th>
                        <th>ต้นทุน</th>
                        <th>ราคาขาย</th>
                        <th style="text-align: right">จำนวนคงเหลือ</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-success btn-product-selected" data-dismiss="modalx" disabled><i
                            class="fa fa-check"></i> ตกลง
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i
                            class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                </button>
            </div>
        </div>

    </div>
</div>

<?php
$url_to_get_branch = \yii\helpers\Url::to(['branchtransfer/getbranch'], true);
$url_to_get_warehouse = \yii\helpers\Url::to(['branchtransfer/getwarehouse'], true);
$url_to_find_item = \yii\helpers\Url::to(['pricegroup/productdata'], true);
$url_to_find_item2 = \yii\helpers\Url::to(['pricegroup/productdata2'], true);
$url_to_get_price_group = \yii\helpers\Url::to(['journalissue/find-pricegroup'], true);

$js = <<<JS
var removelist = [];
var selecteditem = [];
$(function(){
    $(".btn-search-submit").click(function (){
         var txt = $(".search-item").val();
         $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_find_item",
              'data': {txt_search: txt},
              'success': function(data) {
                  //  alert(data);
                   $(".table-find-list tbody").html(data);
                 //  $("#findModal").modal("show");
                 }
              });
      });
});
function whchange(e){
    var wh1 = e.closest('tr').find('.line-from-warehouse').val();
    var wh2 = e.closest('tr').find('.line-select-to-warehouse').val();
    if(wh1 == wh2){
        alert('คลังสินค้าซ้ำกัน');
        e.closest('tr').find('.line-select-to-warehouse').val(-1).change();
        e.closest('tr').find('.line-qty').attr("disabled", true);
        return false;
    }else{
        e.closest('tr').find('.line-qty').attr("disabled", false);
    }
}
function getBranch(e){
     $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_branch" ,
              'data': {'company_id': e.val()},
              'success': function(data) {
                  //  alert(data);
                   e.closest('tr').find(".line-select-from-branch").html(data);
                 //  $("#findModal").modal("show");
                 }
              });
}
function getWarehouse(e){
     $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_warehouse" ,
              'data': {'branch_id': e.val()},
              'success': function(data) {
                  //  alert(data);
                   e.closest('tr').find(".line-select-from-warehouse").html(data);
                 //  $("#findModal").modal("show");
                 }
              });
}
function getBranch2(e){
     $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_branch" ,
              'data': {'company_id': e.val()},
              'success': function(data) {
                  //  alert(data);
                   e.closest('tr').find(".line-select-to-branch").html(data);
                 //  $("#findModal").modal("show");
                 }
              });
}
function getWarehouse2(e){
    //alert(e.val());
     $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_warehouse" ,
              'data': {'branch_id': e.val()},
              'success': function(data) {
                  //  alert(data);
                   e.closest('tr').find(".line-select-to-warehouse").html(data);
                 //  $("#findModal").modal("show");
                 }
              });
}


function getBranch3(e){
   // alert();
     $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_branch" ,
              'data': {'company_id': e.val()},
              'success': function(data) {
                   // alert(data);
                   $(".search-branch").html(data);
                 //  $("#findModal").modal("show");
                 }
              });
}
function getWarehouse3(e){
    //alert(e.val());
     $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_warehouse" ,
              'data': {'branch_id': e.val()},
              'success': function(data) {
                  //  alert(data);
                   $(".search-warehouse").html(data);
                 //  $("#findModal").modal("show");
                 }
              });
}

function getOnhand(){
      var company_id = $(".search-company").val();
      var branch_id = $(".search-branch").val();
      var warehouse_id = $(".search-warehouse").val();
     // alert(company_id);
      if(company_id > 0 && branch_id > 0 && warehouse_id >0){
          //alert();
           $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_find_item2",
              'data': {'company': company_id,'branch': branch_id, 'warehouse': warehouse_id},
              'success': function(data) {
                //    alert(data);
                   $(".table-find-list tbody").html(data);
                 //  $("#findModal").modal("show");
                 }
              });
      }
        
}

function showfind(e){
    $(".search-company").val(-1).change();
    $(".search-branch").val(-1).change();
    $(".search-warehouse").val(-1).change();
    //alert();
      $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_find_item",
              'data': {},
              'success': function(data) {
                  // alert(data);
                   $(".table-find-list tbody").html(data);
                   $("#findModal").modal("show");
                 }
              });
      
  }
  function addselecteditem(e) {
        var id = e.attr('data-var');
        var code = e.closest('tr').find('.line-find-code').val();
        var name = e.closest('tr').find('.line-find-name').val();
        var price = e.closest('tr').find('.line-find-price').val();
        var onhand = e.closest('tr').find('.line-onhand').val();
        
        var company = $(".search-company").val();
        var branch = $(".search-branch").val();
        var warehouse = $(".search-warehouse").val();
        var company_name = $(".search-company option:selected").text();
        var branch_name = $(".search-branch option:selected").text();
        var warehouse_name = $(".search-warehouse option:selected").text();
        
        if (id) {
            if (e.hasClass('btn-outline-success')) {
                var obj = {};
                obj['id'] = id;
                obj['code'] = code;
                obj['name'] = name;
                obj['price'] = price;
                obj['onhand'] = onhand;
                obj['company'] = company;
                obj['branch'] = branch;
                obj['warehouse'] = warehouse;
                obj['company_name'] = company_name;
                obj['branch_name'] = branch_name;
                obj['warehouse_name'] = warehouse_name;
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
            $(".btn-product-selected").prop("disabled", "");
            $(".btn-product-selected").removeClass('btn-outline-success');
            $(".btn-product-selected").addClass('btn-success');
        } else {
            $(".btn-product-selected").prop("disabled", "disabled");
            $(".btn-product-selected").removeClass('btn-success');
            $(".btn-product-selected").addClass('btn-outline-success');
        }
    }
    
    $(".btn-product-selected").click(function () {
      
        var linenum = 0;
        if (selecteditem.length > 0) {
            for (var i = 0; i <= selecteditem.length - 1; i++) {
                var line_prod_id = selecteditem[i]['id'];
                var line_prod_code = selecteditem[i]['code'];
                var line_prod_name = selecteditem[i]['name'];
                var line_from_company = selecteditem[i]['company'];
                var line_from_branch = selecteditem[i]['branch'];
                var line_from_warehouse = selecteditem[i]['warehouse'];
                var line_from_company_name = selecteditem[i]['company_name'];
                var line_from_branch_name = selecteditem[i]['branch_name'];
                var line_from_warehouse_name = selecteditem[i]['warehouse_name'];
                
                 if(check_dup(line_prod_id) == 1){
                        alert("รายการสินค้า " +line_prod_code+ " มีในรายการแล้ว");
                        return false;
                    }
                
                var tr = $("#table-list tbody tr:last");
                
                if (tr.closest("tr").find(".line-product-id").val() == "") {
                    tr.closest("tr").find(".line-product-id").val(line_prod_id);
                    tr.closest("tr").find(".line-product-name").val(line_prod_name);
                    
                    tr.closest("tr").find(".line-from-company").val(line_from_company);
                    tr.closest("tr").find(".line-from-branch").val(line_from_branch);
                    tr.closest("tr").find(".line-from-warehouse").val(line_from_warehouse);
                    tr.closest("tr").find(".line-from-company-name").val(line_from_company_name);
                    tr.closest("tr").find(".line-from-branch-name").val(line_from_branch_name);
                    tr.closest("tr").find(".line-from-warehouse-name").val(line_from_warehouse_name);
                    //alert();
                } else {
                    console.log(line_prod_code);
                    //tr.closest("tr").find(".line_code").css({'border-color': ''});

                    var clone = tr.clone();
                    clone.find(".line-product-id").val(line_prod_id);
                    clone.find(".line-product-name").val(line_prod_name);
                    clone.find(".line-from-company").val(line_from_company);
                    clone.find(".line-from-branch").val(line_from_branch);
                    clone.find(".line-from-warehouse").val(line_from_warehouse);
                    tr.closest("tr").find(".line-from-company-name").val(line_from_company_name);
                    tr.closest("tr").find(".line-from-branch-name").val(line_from_branch_name);
                    tr.closest("tr").find(".line-from-warehouse-name").val(line_from_warehouse_name);
                    clone.attr("data-var", "");
                    clone.find('.rec-id').val("");

                    clone.find(".line-qty").on("keypress", function (event) {
                        $(this).val($(this).val().replace(/[^0-9\.]/g, ""));
                        if ((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which < 48 || event.which > 57)) {
                            event.preventDefault();
                        }
                    });

                    tr.after(clone);
                    //cal_num();
                }
            }
          cal_num();
        }
        $("#table-list tbody tr").each(function () {
            linenum += 1;
            $(this).closest("tr").find("td:eq(0)").text(linenum);
            // $(this).closest("tr").find(".line-prod-code").val(line_prod_code);
        });
        selecteditem.length = 0;

        $("#table-find-list tbody tr").each(function () {
            $(this).closest("tr").find(".btn-line-select").removeClass('btn-success');
            $(this).closest("tr").find(".btn-line-select").addClass('btn-outline-success');
        });
        $(".btn-product-selected").removeClass('btn-success');
        $(".btn-product-selected").addClass('btn-outline-success');
        $("#findModal").modal('hide');
    });

function removeline(e) {
        if (confirm("ต้องการลบรายการนี้ใช่หรือไม่?")) {
            if (e.parent().parent().attr("data-var") != '') {
                removelist.push(e.parent().parent().attr("data-var"));
                $(".remove-list").val(removelist);
            }
            // alert(removelist);

            if ($("#table-list tbody tr").length == 1) {
                $("#table-list tbody tr").each(function () {
                    $(this).find(":text").val("");
                   // $(this).find(".line-prod-photo").attr('src', '');
                    $(this).find(".line-price").val(0);
                    cal_num();
                });
            } else {
                e.parent().parent().remove();
            }
            cal_linenum();
            cal_all();
        }
    }
  function cal_num(){
      $("#table-list tbody tr").each(function(){
          var x = $(this).closest('tr').find('.line-product-id').val();
         // alert(x); 
      });
  }
  function check_dup(prod_id){
      var _has = 0;
      $("#table-list tbody tr").each(function(){
          var p_id = $(this).closest('tr').find('.line-product-id').val();
         // alert(p_id + " = " + prod_id);
          if(p_id == prod_id){
              _has = 1;
          }
      });
      return _has;
    }
JS;
$this->registerJs($js, static::POS_END);
?>
