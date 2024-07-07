<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = $model->order_no;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'รายการขาย'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$wh_data = \backend\models\Warehouse::find()->where(['is_reprocess' => 1])->all();
?>
<div class="car-view">
    <form id="form-submit" method="post" action="<?= \yii\helpers\Url::to(['closeorder/submitorderclose'], true) ?>">
        <input type="hidden" name="order_id" value="<?=$model->id?>">
        <div class="row">
            <div class="col-lg-12">
                <h3>สายส่ง <span style="color: #258faf"><?= $model->route_name ?></span></h3>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>สินค้า</th>
                        <th>เบิก</th>
                        <th>ขาย</th>
                        <th>คงเหลือ</th>
                        <th>คืนเข้าคลัง</th>
                        <th>-</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($modelline as $value): ?>
                        <tr>
                            <td>
                                <?= \backend\models\Product::findName($value->product_id) ?>
                            </td>
                            <td>
                                <?= number_format($value->qty) ?>
                            </td>
                            <td>
                                <?= number_format($value->sale_qty) ?>
                            </td>
                            <td>
                                <?= number_format($value->avl_qty) ?>

                                <input type="hidden" name="line_product_id[]" value="<?=$value->product_id?>">
                                <input type="hidden" name="line_avl_qty[]" value="<?=$value->avl_qty?>">
                            </td>
                            <td>
                                <select name="line_warehouse_id[]" class="form-control line-warehouse-id" id="">
                                    <?php foreach ($wh_data as $value): ?>
                                        <option value="<?= $value->id ?>"><?= $value->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="btn btn-success" onclick="submitform($(this))">บันทึกจบ</div>
            </div>
        </div>
    </form>
</div>

<?php
$js=<<<JS
$(function(){
    
});
function submitform(e){
    if(confirm('คุณต้องการดำเนินการต่อใช่หรือไม่')){
        $("form#form-submit").submit();
    }
}
JS;
$this->registerJs($js,static::POS_END);
?>
