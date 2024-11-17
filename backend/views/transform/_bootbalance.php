<?php
$company_id = 0;
$branch_id = 0;
if (isset($_SESSION['user_company_id'])) {
    $company_id = $_SESSION['user_company_id'];
}
if (isset($_SESSION['user_branch_id'])) {
    $branch_id = $_SESSION['user_branch_id'];
}

?>
<div class="row">
    <div class="col-lg-12">
        <h3>ปรับยอดยกมาสายส่งตลาด</h3>
    </div>
</div>
<form action="<?=\yii\helpers\Url::to(['transform/updatebalance'],true)?>" method="post">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo \kartik\select2\Select2::widget([
                'name' => 'route_id',
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['type_id' => 2,'company_id'=>$company_id,'branch_id'=>$branch_id])->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => 'เลือกสายส่ง'
                ]
            ]);
            ?>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-lg-12">
          <?php
           $product_data = \backend\models\Product::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id,'status'=>1])->all();
          ?>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อ</th>
                    <th>จำนวน</th>
                </tr>
                </thead>
                <tbody>
                 <?php foreach($product_data as $value): ?>
                 <tr>
                     <td>
                         <input type="hidden" name="product_id[]" value="<?=$value->id?>">
                         <?=$value->code?>
                     </td>
                     <td><?=$value->name?></td>
                     <td>
                         <input type="text" name="qty[]" class="form-control" value="0">
                     </td>
                 </tr>
                <?php endforeach;?>
                </tbody>

            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <button type="submit" class="btn btn-success">บันทึก</button>
        </div>
    </div>
</form>