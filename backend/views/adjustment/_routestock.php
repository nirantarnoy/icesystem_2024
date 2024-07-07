<?php
$this->title = 'ปรับสต๊อกสายส่ง';
?>
    <form action="<?= \yii\helpers\Url::to(['adjustment/updatestock'], true) ?>" method="post">
        <div class="row">
            <div class="col-lg-3">
                <label for="">สายส่ง</label>
                <?php
                echo \kartik\select2\Select2::Widget([
                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['status' => 1])->all(), 'id', 'name'),
                    'name' => 'route_id',
                    'options' => [
                        'id' => 'route-id',
                        'placeholder' => 'เลือกสายส่ง'
                    ]

                ]);
                ?>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered" id="table-list">
                    <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 70%">สินค้า</th>
                        <th>จำนวน</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <br/>

        <div class="row">
            <div class="col-lg-3">
                <input class="btn btn-success" type="submit" value="บันทึก">
            </div>
        </div>
    </form>

<?php
$Url_to_find_item = \yii\helpers\Url::to(['adjustment/getstockitem'], true);
$js = <<<JS
$("#route-id").change(function(){
   var id = $(this).val();
 
   if(id > 0){
       
       $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$Url_to_find_item",
              'data': {'route_id': id},
              'success': function(data) {
                    //alert(data);
                   $("#table-list tbody").html(data);
                 //  $("#findModal").modal("show");
              },
              error: function(err){
                  alert(err);
              }
              });
   }
});
JS;
$this->registerJs($js, static::POS_END);
?>