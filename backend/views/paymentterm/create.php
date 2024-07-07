<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Paymentterm */

$this->title = 'สร้างเงื่อนไขการชำระเงิน';
$this->params['breadcrumbs'][] = ['label' => 'เงื่อนไขการชำระเงิน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentterm-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
