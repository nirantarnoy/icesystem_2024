<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'เพิ่มออเดอร์ใหม่';
$this->params['breadcrumbs'][] = $this->title;

$model_product = \backend\models\Product::find()->where(['status'=>1])->all();
$model_route = \backend\models\Deliveryroute::find()->where(['status'=>1,'company_id'=>1,'branch_id'=>1])->all();
$model_customer = \backend\models\Customer::find()->where(['status'=>1])->all();
$model_car = \backend\models\Car::find()->where(['status'=>1])->all();
$model_payment_method = \backend\models\Paymentmethod::find()->where(['status'=>1,'company_id'=>1,'branch_id'=>1])->all();

// Register CSS
$this->registerCss("
    .detail-row {
        margin-bottom: 10px;
    }
    .btn-remove-row {
        margin-top: 0px;
    }
    .table-detail {
        margin-top: 20px;
    }
    .summary-box {
        background: #f5f5f5;
        padding: 15px;
        border-radius: 5px;
        margin-top: 20px;
    }
");
?>

    <div class="order-form-create">
        <form id="order-form" action="<?= Url::to(['orders/addordernew']) ?>" method="post">

            <!-- Master Section -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">ข้อมูลหลัก (Master)</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>สายส่ง (Route) <span class="text-danger">*</span></label>
                                <!--                                <select id="route_id" class="form-control" required>-->
                                <!--                                    <option value="">-- เลือกสายส่ง --</option>-->
                                <!--                                 --><?php //foreach($model_route as $value):?>
                                <!--                                    <option value="--><?php //= $value->id ?><!--">--><?php //= $value->name ?><!--</option>-->
                                <!--                                    --><?php //endforeach;?>
                                <!--                                </select>-->
                                <?php
                                echo \kartik\select2\Select2::widget([
                                    'name' => 'route_id',
                                    'data' => \yii\helpers\ArrayHelper::map($model_route, 'id', 'name'),
                                    'options' => ['placeholder' => 'Select Route ...', 'id' => 'route_id','onchange'=>'findCar($(this))'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>
                            <div class="form-group">
                                <label>ลูกค้า <span class="text-danger">*</span></label>
<!--                                <select id="customer_id" class="form-control" required>-->
<!--                                    <option value="">-- เลือกลูกค้า --</option>-->
<!--                                 --><?php //foreach($model_customer as $value):?>
<!--                                    <option value="--><?php //= $value->id ?><!--">--><?php //= $value->name ?><!--</option>-->
<!--                                    --><?php //endforeach;?>
<!--                                </select>-->
                                <?php
                                   echo \kartik\select2\Select2::widget([
                                       'name' => 'customer_id',
                                       'data' => \yii\helpers\ArrayHelper::map($model_customer, 'id', 'name'),
                                       'options' => ['placeholder' => 'Select Customer ...', 'id' => 'customer_id'],
                                       'pluginOptions' => [
                                           'allowClear' => true
                                       ],
                                   ]);
                                ?>
                            </div>


                            <div class="form-group">
                                <label>รถ <span class="text-danger">*</span></label>
<!--                                <select id="car_id" class="form-control" required>-->
<!--                                    <option value="">-- เลือกรถ --</option>-->
<!--                                   --><?php //foreach($model_car as $value):?>
<!--                                    <option value="--><?php //= $value->id ?><!--">--><?php //= $value->name ?><!--</option>-->
<!--                                    --><?php //endforeach;?>
<!--                                </select>-->
                                <?php
                                echo \kartik\select2\Select2::widget([
                                    'name' => 'car_id',
                                    'data' => \yii\helpers\ArrayHelper::map($model_car, 'id', 'name'),
                                    'options' => ['placeholder' => 'Select Car ...', 'id' => 'car_id'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>

                            <div class="form-group">
                                <label>ประเภทการชำระเงิน <span class="text-danger">*</span></label>
                                <select id="payment_type_id" class="form-control" required>
                                    <option value="">-- เลือกประเภท --</option>
                                   <?php foreach($model_payment_method as $value):?>
                                    <option value="<?= $value->id ?>"><?= $value->name ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ผู้ใช้งาน <span class="text-danger">*</span></label>
                                <input type="number" id="user_id" class="form-control" value="1" required>
                            </div>

                            <div class="form-group">
                                <label>พนักงาน 1 (emp_id)</label>
                                <input type="number" id="emp_id" class="form-control" value="0">
                            </div>

                            <div class="form-group">
                                <label>พนักงาน 2 (emp2_id)</label>
                                <input type="number" id="emp2_id" class="form-control" value="0">
                            </div>

                            <div class="form-group">
                                <label>บริษัท <span class="text-danger">*</span></label>
                                <input type="number" id="company_id" class="form-control" value="1" required>
                            </div>

                            <div class="form-group">
                                <label>สาขา <span class="text-danger">*</span></label>
                                <input type="number" id="branch_id" class="form-control" value="1" required>
                            </div>

                            <div class="form-group">
                                <label>ส่วนลด</label>
                                <input type="number" id="discount" class="form-control" value="0" min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Section -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">รายการสินค้า (Detail)</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-success btn-sm" id="btn-add-row">
                            <i class="glyphicon glyphicon-plus"></i> เพิ่มรายการ
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="detail-table" class="table table-bordered table-striped">
                            <thead>
                            <tr class="bg-success">
                                <th width="5%" class="text-center">#</th>
                                <th width="30%">สินค้า</th>
                                <th width="15%">จำนวน</th>
                                <th width="15%">ราคา</th>
                                <th width="15%">กลุ่มราคา</th>
                                <th width="15%" class="text-right">รวม</th>
                                <th width="5%" class="text-center">จัดการ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Detail rows will be added here dynamically -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary Box -->
                    <div class="summary-box">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <table class="table table-condensed">
                                    <tr>
                                        <td class="text-right"><strong>ยอดรวม:</strong></td>
                                        <td class="text-right"><span id="order-total">0.00</span> บาท</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>ส่วนลด:</strong></td>
                                        <td class="text-right"><span id="discount-display">0.00</span> บาท</td>
                                    </tr>
                                    <tr class="bg-info">
                                        <td class="text-right"><strong>ยอดสุทธิ:</strong></td>
                                        <td class="text-right"><strong><span id="grand-total">0.00</span> บาท</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" id="btn-submit" class="btn btn-primary btn-lg">
                    <i class="glyphicon glyphicon-ok"></i> บันทึก
                </button>
                <a href="<?= Url::to(['order/index']) ?>" class="btn btn-default btn-lg">
                    <i class="glyphicon glyphicon-remove"></i> ยกเลิก
                </a>
            </div>

        </form>
    </div>

<?php
$url_to_get_car = Url::to(['orders/getcustomerbyroute'],true);
$js = <<<'JS'
var rowIndex = 0;

$(document).ready(function() {
    // เพิ่มแถวใหม่
    function addDetailRow() {
        rowIndex++;
        var row = '<tr class="detail-row" data-index="' + rowIndex + '">' +
            '<td class="text-center">' + rowIndex + '</td>' +
            '<td>' +
                '<select class="form-control product-select" name="detail[' + rowIndex + '][product_id]" required>' +
                    '<option value="">-- เลือกสินค้า --</option>' +
                    '<option value="1">PB</option>' +
                    '<option value="2">PS</option>' +
                    '<option value="3">PC</option>' +
                    '<option value="4">P2</option>' +
                    '<option value="5">M</option>' +
                    '<option value="6">K</option>' +
                    '<option value="7">B</option>' +
                    '<option value="8">S</option>' +
                   '<option value="9">SC</option>' +
                   '<option value="15">T1</option>' +
                   '<option value="16">T2</option>' +
                   '<option value="20">R</option>' +
                '</select>' +
            '</td>' +
            '<td>' +
                '<input type="number" class="form-control qty-input" name="detail[' + rowIndex + '][qty]" value="1" min="1" step="1" required>' +
            '</td>' +
            '<td>' +
                '<input type="number" class="form-control price-input" name="detail[' + rowIndex + '][price]" value="0" min="0" step="0.01" required>' +
            '</td>' +
            '<td>' +
                '<input type="number" class="form-control" name="detail[' + rowIndex + '][price_group_id]" value="1" min="1" required>' +
            '</td>' +
            '<td class="text-right line-total">0.00</td>' +
            '<td class="text-center">' +
                '<button type="button" class="btn btn-danger btn-sm btn-remove-row" data-index="' + rowIndex + '">' +
                    '<i class="glyphicon glyphicon-trash"></i> ลบ' +
                '</button>' +
            '</td>' +
        '</tr>';
        
        $('#detail-table tbody').append(row);
        calculateTotal();
    }
    
    // ลบแถว - ใช้ event delegation
    $(document).on('click', '.btn-remove-row', function() {
        var index = $(this).data('index');
        $('tr[data-index="' + index + '"]').remove();
        reorderRows();
        calculateTotal();
    });
    
    // คลิกปุ่มเพิ่มรายการ
    $('#btn-add-row').on('click', function() {
        addDetailRow();
    });
    
    // จัดเรียงเลขที่แถวใหม่
    function reorderRows() {
        $('#detail-table tbody tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
    }
    
    // คำนวณยอดรวม
    function calculateTotal() {
        var total = 0;
        $('#detail-table tbody tr').each(function() {
            var qty = parseFloat($(this).find('.qty-input').val()) || 0;
            var price = parseFloat($(this).find('.price-input').val()) || 0;
            var lineTotal = qty * price;
            $(this).find('.line-total').text(lineTotal.toFixed(2));
            total += lineTotal;
        });
        
        var discount = parseFloat($('#discount').val()) || 0;
        var grandTotal = total - discount;
        
        $('#order-total').text(total.toFixed(2));
        $('#discount-display').text(discount.toFixed(2));
        $('#grand-total').text(grandTotal.toFixed(2));
    }
    
    // Event listeners
    $(document).on('change', '.qty-input, .price-input', function() {
        calculateTotal();
    });
    
    $(document).on('change', '#discount', function() {
        calculateTotal();
    });
    
    $(document).on('change', '#payment_type_id', function() {
        var paymentType = $(this).val();
        if (paymentType == '3') { // ฟรี
            $('#detail-table tbody tr').each(function() {
                $(this).find('.price-input').val(0).prop('readonly', true);
            });
        } else {
            $('#detail-table tbody tr .price-input').prop('readonly', false);
        }
        calculateTotal();
    });
    
    // Submit form
    $('#order-form').on('submit', function(e) {
        e.preventDefault();
        
        if ($('#detail-table tbody tr').length === 0) {
            alert('กรุณาเพิ่มรายการสินค้าอย่างน้อย 1 รายการ');
            return false;
        }
        
        // สร้าง data array
        var detailData = [];
        $('#detail-table tbody tr').each(function() {
            detailData.push({
                product_id: parseInt($(this).find('.product-select').val()),
                qty: parseInt($(this).find('.qty-input').val()),
                price: parseFloat($(this).find('.price-input').val()),
                price_group_id: parseInt($(this).find('input[name*="price_group_id"]').val())
            });
        });
        
        // สร้าง request data
        var requestData = {
            customer_id: parseInt($('#customer_id').val()),
            user_id: parseInt($('#user_id').val()),
            emp_id: parseInt($('#emp_id').val()) || 0,
            emp2_id: parseInt($('#emp2_id').val()) || 0,
            route_id: parseInt($('#route_id').val()),
            car_id: parseInt($('#car_id').val()),
            payment_type_id: parseInt($('#payment_type_id').val()),
            company_id: parseInt($('#company_id').val()),
            branch_id: parseInt($('#branch_id').val()),
            discount: parseFloat($('#discount').val()) || 0,
            data: detailData
        };
        
        console.log('Request Data:', requestData);
        
        // ส่งข้อมูลไปยัง API
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(requestData),
            beforeSend: function() {
                $('#btn-submit').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> กำลังบันทึก...');
            },
            success: function(response) {
                console.log('Response:', response);
                if (response.status) {
                    alert('บันทึกข้อมูลสำเร็จ');
                    window.location.reload();
                } else {
                    alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                alert('เกิดข้อผิดพลาด: ' + xhr.responseText);
            },
            complete: function() {
                $('#btn-submit').prop('disabled', false).html('<i class="glyphicon glyphicon-ok"></i> บันทึก');
            }
        });
    });
    
    // เพิ่มแถวแรกเมื่อโหลดหน้า
    addDetailRow();
});

function findCar(e){
        var id = e.val();
        if(id > 0){
            $.ajax({
            'type': 'post',
            'dataType': 'html',
            'url': 'index.php?r=orders/getcarbyroute',
            'data':{'id': id},
            'success': function(data){
                if(data !== ''){
                    $("#car_id").html(data);
                   // alert(data);
                }else{
                  //  alert('No data');
                }
            },
            'error': function(err){
                console.log(err);
               // alert("Error");
            }
            });
            findCustomer(id);
        }
        
}
function findCustomer(id){
       // var id = e.val();
        if(id > 0){
            $.ajax({
            'type': 'post',
            'dataType': 'html',
            'url': 'index.php?r=orders/getcustomerbyroute',
            'data':{'id': id},
            'success': function(data){
                if(data !== ''){
                    $("#customer_id").html(data);
                  // alert(data);
                }else{
                  // alert('No data');
                }
            },
            'error': function(err){
                console.log(err);
               // alert("Error");
            }
            });
        }
    }
JS;

$this->registerJs($js, \yii\web\View::POS_END);
?>