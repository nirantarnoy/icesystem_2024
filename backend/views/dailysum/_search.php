<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\JournalissueSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="journalissue-search">

    <?php $form = ActiveForm::begin([
        'action' => ['indexnew'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-lg-3">
            <div class="label">
                เลือกดูตามวันที่
            </div>
            <div class="input-group">
                <?php
                echo \kartik\date\DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'post_date',
                    'options' => [
                        'autocomplete' => 'off',
                        'class'=> 'trans_date',
                    ],
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'todayHighlight' => true,
                    ]
                ]);
                ?>
            </div>

        </div>
        <div class="col-lg-3">
            <div class="label">
                สายส่ง
            </div>
            <div class="input-group">
                <?php
                echo \kartik\select2\Select2::widget([
                    'model' => $model,
                    'attribute' => 'route_id',
                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id, 'status'=>1])->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => 'เลือกสายส่ง',
                        'onchange' => 'getshiftemp($(this));'

                    ]
                ]);
                ?>
            </div>

        </div>
        <div class="col-lg-3">
            <div class="label">พนักงาน</div>
<!--            <select name="employee" id="" class="form-control selected-employee">-->
<!--                <option value="0">--เลือกพนักงาน--</option>-->
<!--            </select>-->
            <?php
            $emp_id = \backend\models\User::findEmpId($model->employee_id);
            if($emp_id > 0){
                $model->employee_id = $emp_id;
            }

            echo \kartik\select2\Select2::widget([
                'model' => $model,
                'attribute' => 'employee_id',
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Employee::find()->where(['company_id' => $company_id,'branch_id'=>$branch_id,'id'=>$emp_id])->all(), 'id', 'fname'),
                'options' => [
                    'placeholder' => 'เลือกพนักงาน',
                    'class'=> 'selected-employee',
                ]
            ]);
            ?>
        </div>
        <div class="col-lg-2">
            <input type="hidden" name="isnew" value="1">
            <div class="label"
                 style="color: white">
                ค้นหา
            </div>
            <input type="submit"
                   class="btn btn-primary"
                   value="ค้นหา"></input>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$url_to_find_emp = \yii\helpers\Url::to(['dailysum/findshiftemp'],true);
$js=<<<JS
function getshiftemp(e){
    var ids = e.val();
    var trans_date = $(".trans_date").val();
    if(ids!=null){
         $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_find_emp",
              'data': {'id': ids,'trans_date': trans_date},
              'success': function(data) {
                  // alert(data);
                  if(data == ''){
                    $(".selected-employee").html(data);
                  }else{
                      $(".selected-employee").html(data);
                      //$(".text-car-emp").html(data[0]['html']);
                  }
              }
         });
    }
}
JS;
$this->registerJs($js,static::POS_END);

?>