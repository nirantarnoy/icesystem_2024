<?php
 // echo $model->route_code;
  $model_detail = \backend\models\Productgroup::find()->all();
?>

<div class="row">
    <div class="col-lg-5"></div>
  <div class="col-lg-7">
      <p>แยกตามการชำระเงิน</p>
    <table class="table">
       <?php foreach ($model_detail as $value):?>
       <tr>
         <td><?=$value->code?></td>
           <td><?=$value->name?></td>
           <td><?=number_format(1000)?></td>
       </tr>
      <?php endforeach;?>
    </table>
  </div>
</div>
