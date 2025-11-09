<?php
$this->title = 'Admin Tools';
$company_id = 0;
$branch_id = 0;

if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id = \Yii::$app->user->identity->branch_id;
}

$url_to_get_login_time = \yii\helpers\Url::to(['admintools/findlogintime'], true);
?>
<br />
<div class="row">
   <div class="col-lg-12">
       <h4>อัพเดทเวลาเข้าระบบผู้ใช้งาน</h4>
   </div>
</div>

<form action="<?=\yii\helpers\Url::to(['admintools/updatelogin'],true)?>" method="post">
    <div class="row">
        <div class="col-lg-5">
            <?php
             echo \kartik\select2\Select2::widget([
                 'name'=>'user_update_log',
                 'data'=> \yii\helpers\ArrayHelper::map(\backend\models\User::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id,'status'=>1])->all(),'id','username'),
                     'options' => [
                         'placeholder'=>'เลือกผู้ใช้งาน',
                         'onchange'=>' 
                         //alert($(this).val());
                           $.ajax({
                                   type: "post",
                                   dataType: "html",
                                   url: "'.$url_to_get_login_time.'",
                                   data: {"user_id": $(this).val()},
                                   success: function(data){
                                 //    alert(data);
                                    if(data != ""){
                                       $(".show-time").html(data);
                                       $(".show-time").show();
                                    }else{
                                      $(".show-time").html("");
                                       $(".show-time").hide();
                                    }
                                  
                                   },
                                   error: function(err){
                                    // alert(err);
                                    alert("error");
                                   }
                          });          
                        '
                     ]
                 ]
             );
            ?>
            <br />
            <span>จะเปลี่ยนเป็น  <span class="show-time" style="display: none;color: red;"></span></span>

        </div>
        <div class="col-lg-1">
         <button class="btn btn-success">อัพเดท</button>
        </div>
        <div class="col-lg-3"></div>
        <div class="col-lg-3"></div>
    </div>
</form>
<br />
<hr>
<div class="row">
    <div class="col-lg-12">
        <h4>แก้ยกเลิกรับสินค้าสายส่ง</h4>
    </div>
</div>

<form action="<?=\yii\helpers\Url::to(['admintools/updateissuecancel'],true)?>" method="post">
    <div class="row">
        <div class="col-lg-3">
            <?php
            echo \kartik\select2\Select2::widget([
                    'name'=>'issue_id',
                    'data'=> \yii\helpers\ArrayHelper::map(\common\models\JournalIssue::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id,'status'=>200])->all(),'id','journal_no'),
                    'options' => [
                        'placeholder'=>'เลือกเลขที่ใบเบิก',

                    ]
                ]
            );
            ?>
        </div>
        <div class="col-lg-3">
            <button class="btn btn-success">อัพเดท</button>
        </div>
        <div class="col-lg-3"></div>
        <div class="col-lg-3"></div>
    </div>
</form>

<br />
<hr>
<div class="row">
    <div class="col-lg-12">
        <h4>ดึงข้อมูลขายสายส่ง</h4>
    </div>
</div>

<form action="<?=\yii\helpers\Url::to(['admintools/rollbacksale'],true)?>" method="post">
    <div class="row">
        <div class="col-lg-3">
            <?php
            echo \kartik\select2\Select2::widget([
                    'name'=>'route_id',
                    'data'=> \yii\helpers\ArrayHelper::map(\common\models\DeliveryRoute::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id,'status'=>1])->all(),'id','name'),
                    'options' => [
                        'placeholder'=>'เลือกสายส่ง',

                    ]
                ]
            );
            ?>
        </div>
        <div class="col-lg-3">
            <button class="btn btn-success">ดึงข้อมูล</button>
        </div>
        <div class="col-lg-3"></div>
        <div class="col-lg-3"></div>
    </div>
</form>