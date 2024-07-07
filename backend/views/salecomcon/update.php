<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Salecomcon */

$this->title = 'แก้ไขเงื่อไขพิเศษ: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'เงื่อนไขพิเศษ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="salecomcon-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
