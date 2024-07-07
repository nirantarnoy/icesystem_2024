<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */

$this->title = Yii::t('app', 'แก้ไขใบสั่งขาย: {name}', [
    'name' => $model->order_no,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ใบสั่งขาย'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_no, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'แก้ไข');
?>
<div class="orders-update">
    <?= $this->render('_form', [
        'model' => $model,
        'model_line' => null,
        'model_has_transfer' => $model_has_transfer,
        'order_issue_list' => $order_issue_list
    ]) ?>

</div>
