<?php
?>
    <div class="row">
        <div class="col-lg-12">
            <h3>รายการแจ้งเพิ่ม ถัง/กระสอบ</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ลูกค้า</th>
                    <th>รหัส</th>
                    <th>รูปภาพ</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model as $value): ?>
                    <tr>
                        <td>
                            <?= \backend\models\Customer::findName($value->customer_id) ?>
                        </td>
                        <td>
                            <?= \backend\models\Assetsitem::findCode($value->asset_id) ?>
                        </td>
                        <td>
                            <?= \backend\models\Customer::findName($value->customer_id) ?>
                        </td>
                        <td>
                            <a href="<?= \yii\helpers\Url::to(['assetsitem/asset-request-update', 'id' => $value->id], true) ?>"
                               target="_parent" class="btn btn-info">รายละเอียด</a>
                            <div class="btn btn-danger" data-var="<?= $value->id ?>" onclick="deleteline($(this))">ลบ
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <form id="form-delete" action="<?= \yii\helpers\Url::to(['assetsitem/delete-request'], true) ?>" method="post">
        <input type="hidden" class="delete-id" value="" name="delete_id">
    </form>

<?php
$js = <<<JS
$(function(){
    
});

function deleteline(e){
    var id = e.attr("data-var");
    if(id > 0){
        if(confirm('ต้องการลบข้อมูลใช่หรือไม่')){
            $(".delete-id").val(id);
            $("form#form-delete").submit();
        }
    }
}
JS;
$this->registerJs($js, static::POS_END);
?>