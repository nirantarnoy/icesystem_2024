<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Paymentmethod */

$this->title = 'สร้างวิธีชำระเงิน';
$this->params['breadcrumbs'][] = ['label' => 'วิธีชำระเงิน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentmethod-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
