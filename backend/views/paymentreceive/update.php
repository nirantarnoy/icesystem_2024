<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Paymentreceive */

$this->title = 'แก้ไขรายการชำระ: ' . $model->journal_no;
$this->params['breadcrumbs'][] = ['label' => 'ชำระหนี้', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->journal_no, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="paymentreceive-update">

    <?= $this->render('_form', [
        'model' => $model,
        'model_line' => $model_line,
    ]) ?>

</div>
