<?php
 // echo $model->route_code;

  $model_detail = \common\models\QueryPlan::find()->where(['product_id'=>$product_id])->all();
?>

<div class="row">
    <div class="col-lg-5"></div>
  <div class="col-lg-7">
<!--      <p>แยกตามการชำระเงิน</p>-->
    <table class="table" style="border: 0px">
       <?php foreach ($model_detail as $value):?>
       <tr>
         <td><?=$value->customer_name?></td>
           <td style="text-align: right"><?=number_format($value->qty)?></td>
       </tr>
      <?php endforeach;?>
    </table>
  </div>
</div>
