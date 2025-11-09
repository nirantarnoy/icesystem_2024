<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerrequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customerrequest-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'journal_no') ?>

    <?= $form->field($model, 'trans_date') ?>

    <?= $form->field($model, 'customer_ref_id') ?>

    <?= $form->field($model, 'customer_name') ?>

    <?php // echo $form->field($model, 'age') ?>

    <?php // echo $form->field($model, 'idcard_no') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'moo') ?>

    <?php // echo $form->field($model, 'district_id') ?>

    <?php // echo $form->field($model, 'city_id') ?>

    <?php // echo $form->field($model, 'province_id') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'company_name') ?>

    <?php // echo $form->field($model, 'route_id') ?>

    <?php // echo $form->field($model, 'route_num') ?>

    <?php // echo $form->field($model, 'start_date') ?>

    <?php // echo $form->field($model, 'sale_price') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'payment_method_id') ?>

    <?php // echo $form->field($model, 'account_no') ?>

    <?php // echo $form->field($model, 'credit_term') ?>

    <?php // echo $form->field($model, 'account_credit_no') ?>

    <?php // echo $form->field($model, 'after_invoice_day') ?>

    <?php // echo $form->field($model, 'user_box') ?>

    <?php // echo $form->field($model, 'marget_emp_id') ?>

    <?php // echo $form->field($model, 'market_emp_date') ?>

    <?php // echo $form->field($model, 'is_approve') ?>

    <?php // echo $form->field($model, 'approve_emp_id') ?>

    <?php // echo $form->field($model, 'approve_date') ?>

    <?php // echo $form->field($model, 'is_shop_place') ?>

    <?php // echo $form->field($model, 'emp_operate_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
