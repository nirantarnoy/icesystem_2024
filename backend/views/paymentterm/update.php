<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Paymentterm */

$this->title = 'แก้ไขเงื่อนไขการชำระเงิน: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'เงื่อนไขการชำระเงิน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="paymentterm-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
