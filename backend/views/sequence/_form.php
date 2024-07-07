<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\Url;
use kartik\select2\Select2;
use toxor88\switchery\Switchery;
use kartik\checkbox\CheckboxX;

?>
    <div class="panel panel-headlin">
        <div class="panel-heading">

                    <div class="clearfix"></div>
                  </div>
                  <div class="panel-body">
                    <br />
                               <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal form-label-left']]); ?>
                               <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ระบบงาน <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'module_id')->widget(Select2::className(),[
                                        'data'=> ArrayHelper::map(\backend\helpers\RunnoTitle::asArrayObject(),'id','name')
                                    ])->label(false) ?>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">คำตั้งต้น
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'prefix')->textInput(['maxlength' => true,'class'=>'form-control','id'=>'prefix','onchange'=>'calrunno();','style'=>'text-transform: uppercase;'])->label(false) ?>
                                </div>
                              </div>


                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ปรับรูปแบบ
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-inline">
                                        <?=$form->field($model, 'use_year')->widget(CheckboxX::classname(), [
                                            'autoLabel'=>false,
                                            'pluginOptions'=>['threeState'=>false],
                                            'options'=>['id'=>'use_year','onchange'=>'calrunno();']
                                            ]);?>
                                         <?=$form->field($model, 'use_month')->widget(CheckboxX::classname(), [
                                            'autoLabel'=>false,
                                            'pluginOptions'=>['threeState'=>false],
                                            'options'=>['id'=>'use_month','onchange'=>'calrunno();']
                                            ]);?>
                                           <?=$form->field($model, 'use_day')->widget(CheckboxX::classname(), [
                                            'autoLabel'=>false,
                                            'pluginOptions'=>['threeState'=>false],
                                            'options'=>['id'=>'use_day','onchange'=>'calrunno();']
                                            ]);?>
                                    </div>

                                </div>
                              </div>
                               <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">สัญลักษ์
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'symbol')->textInput(['maxlength' => true,'class'=>'form-control','id'=>'symbol','onchange'=>'calrunno();'])->label(false) ?>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ค่าต่ำสุด
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'minimum')->textInput(['maxlength' => true,'class'=>'form-control','id'=>'minimum'])->label(false) ?>
                                </div>
                              </div>
                                <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ค่าสูงสุด
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'maximum')->textInput(['maxlength' => true,'class'=>'form-control','id'=>'maximum','onchange'=>'calrunno();'])->label(false) ?>
                                </div>
                              </div>
                               <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ค่าปัจจุบัน
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'currentnum')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">สถานะ
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php echo $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label(false) ?>
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ผลลัพธ์
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <h1><p class="show_result"></p></h1>
                                </div>
                              </div>


                             <div class="ln_solid"></div>
                        <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                                </div>
                        </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>

<?php
$this->registerJs('
    $(function(){
          var pre = $("#prefix").val().toUpperCase();
            var sym = $("#symbol").val();
            var mini = $("#minimum").val();
            var maxi = $("#maximum").val();
            
            var nums = "";
            var isyear = "";
            var ismonth = "";
            var isday = "";
            var i;
            for(i = 0;i<=maxi.length-1;i++){
                nums = nums+"0";
            }
            if($("#use_year").val()==1){
               var dt = new Date().getFullYear().toString().substr(-2);
               isyear = dt;
            }else{
               isyear = "";
            }
            if($("#use_month").val()==1){
               var dt = new Date().getMonth()+1;
               ismonth = dt;
            }else{
               ismonth = "";
            }
            if($("#use_day").val()==1){
               var dt = new Date().getDate();
               isday = dt;
            }else{
               isday = "";
            }
            var fulltext = pre + sym + isyear + ismonth + isday + nums;
            $(".show_result").text(fulltext);
    });
    
         function calrunno(){
            var pre = $("#prefix").val().toUpperCase();
            var sym = $("#symbol").val();
            var mini = $("#minimum").val();
            var maxi = $("#maximum").val();
            
            var nums = "";
            var isyear = "";
            var ismonth = "";
            var isday = "";
            var i;
            for(i = 0;i<=maxi.length-1;i++){
                nums = nums+"0";
            }
            if($("#use_year").val()==1){
               var dt = new Date().getFullYear().toString().substr(-2);
               isyear = dt;
            }else{
               isyear = "";
            }
            if($("#use_month").val()==1){
               var dt = new Date().getMonth()+1;
            
               ismonth = dt < 10?"0"+dt:dt;
            }else{
               ismonth = "";
            }
            if($("#use_day").val()==1){
               var dt = new Date().getDate();
               isday = dt < 10?"0"+dt:dt;
            }else{
               isday = "";
            }
            var fulltext = pre + sym + isyear + ismonth + isday + nums;
            $(".show_result").text(fulltext);
        }
    ',static::POS_END);
?>
