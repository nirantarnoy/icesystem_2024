<?php

use kartik\date\DatePicker;

$this->title = 'จัดการข้อมูลรถประจำวัน';
$this->params['breadcrumbs'][] = $this->title;

$model = $dataProvider->getModels();
$model_new = null;
$emp_daily_name = '';
//if($model == null){
$model_new = $model_car;

//}
//$emp_data = \common\models\USRPWOPERSON::find()->where(['WCID' => 'PTVB'])->all();
//echo count($model);return;
//print_r($model);return;
?>
<br/>
<div class="row">
    <div class="col-lg-9">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <div class="col-lg-3" style="text-align: right">
        <div class="btn btn-info" onclick="showcopy($(this))"><i class="fa fa-copy"></i> Copy ข้อมูล</div>
        <div class="btn btn-warning" onclick="showgetdefault($(this))"><i class="fa fa-users-cog"></i> ดึงค่าเริ่มต้น
        </div>
    </div>
</div>
<br/>
<?php if ($model_new != null): ?>
    <div class="row">
        <!--    <div class="col-lg-12">-->
        <?php $i = 0; ?>
        <?php foreach ($model_new as $value): ?>
            <?php $i += 1; ?>
            <?php
            $status_name = 'Close';
            $status_color = 'bg-white';
            $stream_status = 'Close';
            $route_name = \common\models\QueryCarRoute::find()->where(['id' => $value->id])->one();

            $assign_id = 0;
            $stream_assign_date = '';
            //if ($i <= 10) $status_color = 'bg-success';
            // if (\backend\models\Streamer::getStatus($value->NAME)) $status_color = 'Open';
            //    print_r($model);
            $emp_daily_name = '';
            //$xx_id = 0;
            $xi = 0;
            foreach ($model as $value2) {
                if ($value2->car_id == $value->id) {
                    $status_color = 'bg-success';
                    if ($xi == 0) {
                        $x_name = \backend\models\Employee::findName2($value2->employee_id);
                        if ($x_name != '') {
                            $emp_daily_name = $x_name;
                        }
                        //$xx_id = $value2->id;
                    } else {
                        $x_name = \backend\models\Employee::findName2($value2->employee_id);
                        //$xx_id = $value2->id;
                        if ($x_name != '') {
                            if ($emp_daily_name != '') {
                                $emp_daily_name = $emp_daily_name . '<br />' . $x_name;
                            } else {
                                $emp_daily_name = $x_name;
                            }

                        }

                    }
                }
                $xi += 1;
            }
            //  return;
            ?>
            <div class="col-lg-2 col-3">
                <!-- small box -->
                <a href="#" data-id="<?= $value->id ?>" data-var="<?= $value->emp_qty ?>"
                   onclick="showcarinfo($(this))" class="small-box <?= $status_color ?>">
                    <div class="inner" style="text-align: right">
                        <h6><b><?= $value->name ?></b></h6>
                        <p style="color: #fcd25a"><?php echo $route_name->route_code ?></p>
                    </div>
                    <!--                    <div class="icon">-->
                    <!--                        <i class="fas fa-truck"></i>-->
                    <!--                       <img src="../web/uploads/images/streamer/streamer.jpg" width="50%" alt="">-->
                    <!--                    </div>-->
                    <div style="text-align: center">
                        <p style="color: #000b16"><b><?= $emp_daily_name ?></b></p>
                    </div>

                    <div class="small-box-footer"></div>
                </a>
            </div>
        <?php endforeach; ?>
        <!--    </div>-->
    </div>
<?php endif; ?>

<div id="empModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="row" style="width: 100%">
                    <div class="col-lg-9">
                        <h4><i class="fa fa-user text-success"></i> พนักงานประจำรถ</h4>
                    </div>
                    <div class="col-lg-3" style="text-align: right">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            </div>
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->
            <form action="<?= \yii\helpers\Url::to(['cardaily/addemp'], true) ?>" method="post">
                <input type="hidden" class="selected-car" name="selected_car" value="">
                <input type="hidden" class="selected-route-id" name="selected_route_id" value="">
                <input type="hidden" class="selected-date-add" name="selected_date" value="">
                <input type="hidden" class="selected-emp-qty" name="selected_emp_qty" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-striped table-car-emp" id="table-list">
                                <thead>
                                <tr>
                                    <th style="text-align: center" width="5%">#</th>
                                    <th>รหัส</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>คนขับ</th>
                                    <th width="5%">-</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="text-align: center"></td>
                                    <td>
                                        <input type="text" class="form-control line-car-emp-code"
                                               name="line_car_emp_code[]" value="" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control line-car-emp-name"
                                               name="line_car_emp_name[]" value="" readonly>
                                    </td>
                                    <td>
                                        <select name="line_car_driver[]" class="form-control line-car-driver" id="">
                                            <option value="1">YES</option>
                                            <option value="0">NO</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" class="line-car-emp-id" value="" name="line_car_emp_id[]">
                                        <div class="btn btn-danger btn-sm" onclick="removeline($(this))"><i
                                                    class="fa fa-trash"></i></div>
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td>
                                        <div class="btn btn-primary" onclick="showempdata($(this))"><i
                                                    class="fa fa-plus"></i></div>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-3" style="text-align: center">
                            <div class="label">เลขไมล์</div>
                            <input type="text" style="text-align: center" class="form-control meter-last" value="0"
                                   readonly>
                        </div>
                        <div class="col-lg-3">
                            <div class="label" style="text-align: center">เลขไมล์วันนี้</div>
                            <input type="text" style="text-align: center" class="form-control meter-today" value="0">
                        </div>
                        <div class="col-lg-3"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
<div id="findModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-lg-11">
                        <div class="input-group">
                            <input type="text" class="form-control search-item" placeholder="ค้นหาพนักงาน">
                            <span class="input-group-addon">
                                        <button type="submit" class="btn btn-primary btn-search-submit">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </span>
                        </div>
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
                        <th>รหัสพนักงาน</th>
                        <th>ชื่อ-นามสกุล</th>
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
<div id="copyModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="row" style="width: 100%">
                    <div class="col-lg-9">
                        <h4><i class="fa fa-copy text-success"></i> Copy ข้อมูล</h4>
                    </div>

                    <div class="col-lg-3" style="text-align: right">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>

            </div>
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->
            <form action="<?= \yii\helpers\Url::to(['cardaily/copydailytrans'], true) ?>" method="post">
                <input type="hidden" class="selected-date" name="selected_date" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-2">
                            จากวันที่
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control original-date" name="from_date" value="" readonly>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-lg-2">
                            ไปวันที
                        </div>
                        <div class="col-lg-6">
                            <?php
                            echo DatePicker::widget([
                                'name' => 'to_date',
                                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                'value' => date('d/m/Y'),
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd/mm/yyyy'
                                ]
                            ]);
                            ?>
                            <!--                            <input type="text" class="form-control new-date" name="to_date" value="" autocomplete="off">-->
                        </div>
                        <div class="col-lg-2">
                            <div class="btn btn-warning">วันนี้</div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">ตกลง</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
<div id="getoriginModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="row" style="width: 100%">
                    <div class="col-lg-9">
                        <h4><i class="fa fa-copy text-success"></i> ดึงข้อมูลค่าเริ่มต้นจากแฟ้มรถ</h4>
                    </div>

                    <div class="col-lg-3" style="text-align: right">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>

            </div>
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->
            <form action="<?= \yii\helpers\Url::to(['cardaily/copyfromoriginal'], true) ?>" method="post">
                <input type="hidden" class="selected-date" name="selected_date" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-2">
                            วันที
                        </div>
                        <div class="col-lg-6">
                            <?php
                            echo DatePicker::widget([
                                'name' => 'to_date',
                                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                'value' => date('d/m/Y'),
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd/mm/yyyy'
                                ]
                            ]);
                            ?>
                            <!--                            <input type="text" class="form-control new-date" name="to_date" value="" autocomplete="off">-->
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">ตกลง</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
<?php
$url_to_find_item = \yii\helpers\Url::to(['orders/empdata'], true);
$url_to_check_has_emp = \yii\helpers\Url::to(['orders/checkhasempdata'], true);
$url_to_find_emp_item = \yii\helpers\Url::to(['orders/findempdata'], true);
$url_to_delete_emp_item = \yii\helpers\Url::to(['orders/deletecaremp'], true);
$js = <<<JS
  var removelist = [];
  var selecteditem = [];
  $(function(){
     // $(".btn-search").trigger('click');
      $(".btn-search-submit").click(function (){
         var txt = $(".search-item").val();
         $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_find_item" ,
              'data': {txt_search: txt},
              'success': function(data) {
                  //  alert(data);
                   $(".table-find-list tbody").html(data);
                 //  $("#findModal").modal("show");
                 }
              });
      });
  });
  function showcarinfo(e){
      var ids = e.attr('data-id');
      var t_date = $("#car-trans-date").val();
      var route_id = $("#route-id").val();
      var emp_qty = e.attr('data-var');
      
     // alert(emp_qty);
      if(ids && t_date != ''){
          $(".selected-car").val(ids);
          $(".selected-route-id").val(route_id);
          $(".selected-date-add").val(t_date);
          $(".selected-emp-qty").val(emp_qty);
          $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_find_emp_item",
              'data': {"car_id": ids, "trans_date": t_date,"route_id": route_id},
              'success': function(data) {
                  //  alert(data);
                  if(data != ''){
                      $("#table-list tbody").html(data);
                  }else{
                      $("#table-list tbody").html('');
                  }
                 $("#empModal").modal('show');
                 }
        });
      }
  }
  
  function showempdata(e){
      //alert();
        $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_find_item",
              'data': {},
              'success': function(data) {
                  //  alert(data);
                   $(".table-find-list tbody").html(data);
                   $("#findModal").modal("show");
                 }
        });
  }
  function addselecteditem(e) {
        var id = e.attr('data-var');
        var code = e.closest('tr').find('.line-find-emp-code').val();
        var name = e.closest('tr').find('.line-find-emp-name').val();
        if (id) {
            if(checkhasempdaily(id)){
                alert("คุณได้ทำการจัดรถให้พนักงานคนนี้ไปแล้ว");
                return false;
            }
            if (e.hasClass('btn-outline-success')) {
                var obj = {};
                obj['id'] = id;
                obj['code'] = code;
                obj['name'] = name;
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
    function checkhasempdaily(emp_id){
      var t_date = $("#car-trans-date").val();
      var res = false;
      if(emp_id){
          $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_check_has_emp" ,
              'data': {'emp_id': emp_id, 'trans_date': t_date},
              'success': function(data) {
                 // alert(data);
                   if(data >0){
                       res = true;
                   }else{
                       res = false;
                   }
              }
          });
      }
       return res;
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
       if((line_count + selecteditem.length ) > 2){
            alert('จำนวนพนักงานเกินกว่าที่กำหนด');
            return false;
        }
        
        if (selecteditem.length > 0) {
            for (var i = 0; i <= selecteditem.length - 1; i++) {
                var line_prod_id = selecteditem[i]['id'];
                var line_prod_code = selecteditem[i]['code'];
                var line_prod_name = selecteditem[i]['name'];
             
                //alert(line_prod_id);
                if(check_dup(line_prod_id) == 1){
                        alert("รายชื่อพนักงาน " +line_prod_code+ " มีในรายการแล้ว");
                        return false;
                }
                
                var tr = $("#table-list tbody tr:last");
                
                if (tr.closest("tr").find(".line-car-emp-code").val() == "") {
                  //  alert(line_prod_code);
                    tr.closest("tr").find(".line-car-emp-id").val(line_prod_id);
                    tr.closest("tr").find(".line-car-emp-code").val(line_prod_code);
                    tr.closest("tr").find(".line-car-emp-name").val(line_prod_name);
                    console.log(line_prod_code);
                } else {
                   // alert("dd");
                    console.log(line_prod_code);
                    //tr.closest("tr").find(".line_code").css({'border-color': ''});

                    var clone = tr.clone();
                    //clone.find(":text").val("");
                    // clone.find("td:eq(1)").text("");
                    clone.find(".line-car-emp-id").val(line_prod_id);
                    clone.find(".line-car-emp-code").val(line_prod_code);
                    clone.find(".line-car-emp-name").val(line_prod_name);
                    clone.attr("data-var", "");
                    clone.find('.rec-id').val("");
                    
                    tr.after(clone);
                    //cal_num();
                }
            }
        //  cal_num();
        }
        $("#table-list tbody tr").each(function () {
           linenum += 1;
            $(this).closest("tr").find("td:eq(0)").text(linenum);
            // $(this).closest("tr").find(".line-prod-code").val(line_prod_code);
        });
      
        selecteditem = [];

        $("#table-find-list tbody tr").each(function () {
            $(this).closest("tr").find(".btn-line-select").removeClass('btn-success');
            $(this).closest("tr").find(".btn-line-select").addClass('btn-outline-success');
        });
        
        $(".btn-emp-selected").removeClass('btn-success');
        $(".btn-emp-selected").addClass('btn-outline-success');
        $("#findModal").modal('hide');
    });
  
  function check_dup(prod_id){
      var _has = 0;
      $("#table-list tbody tr").each(function(){
          var p_id = $(this).closest('tr').find('.line-car-emp-id').val();
         // alert(p_id + " = " + prod_id);
          if(p_id == prod_id){
              _has = 1;
          }
      });
      return _has;
    }
  
  function removeline(e){
      var ids = e.closest('tr').find('.line-car-daily-id').val();
      var row = e.parent().parent();
      
      if(ids){
          if(confirm('ต้องการลบรายการนี้ใช่หรือไม่ ?')){
           $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_delete_emp_item",
              'data': {"id": ids},
              'success': function(data) {
                  //  alert(data);
                   if(data > 0){
                       if($(".table-car-emp tbody tr").length == 1){
                           row.closest("tr").find(".line-car-emp-code").val('');
                           row.closest("tr").find(".line-car-emp-name").val('');
                           row.closest("tr").find(".line-car-emp-id").val('');
                       }else{
                            e.parent().parent().remove();
                       }
                      
                   }
                  // $("#findModal").modal("show");
                 }
        });   
          }
      }else{
         if($(".table-car-emp tbody tr").length == 1){
                           row.closest("tr").find(".line-car-emp-code").val('');
                           row.closest("tr").find(".line-car-emp-name").val('');
                           row.closest("tr").find(".line-car-emp-id").val('');
                       }else{
                            e.parent().parent().remove();
                       }
      }
      var linenum = 0;
       $("#table-list tbody tr").each(function () {
            linenum += 1;
       });
       //$(".selected-emp-qty").val(linenum);
  }  
  
  function showcopy(e){
      var select_date = $("#car-trans-date").val();
      $(".original-date").val(select_date);
      $("#copyModal").modal("show");
  }
  
  function showgetdefault(e){
      $("#getoriginModal").modal("show");
  }
    
JS;
$this->registerJs($js, static::POS_END);
?>
