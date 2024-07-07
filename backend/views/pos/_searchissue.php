<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\JournalissueSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="journalissue-search">

    <?php $form = ActiveForm::begin([
        'action' => ['listissue'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-lg-6">

                <!--         <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>-->
                <?= $form->field($model, 'globalSearch')->textInput(['placeholder'=>'ค้นหา','class'=>'form-control','aria-describedby'=>'basic-addon1'])->label(false) ?>


        </div>
        <div class="col-lg-6">
            <input type="submit" class="btn btn-primary" value="ค้นหา">
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
