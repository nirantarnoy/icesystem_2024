<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Paymentmethod */

$this->title = 'แก้ไขวิธีชำระเงิน: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'วิธีชำระเงิน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="paymentmethod-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
