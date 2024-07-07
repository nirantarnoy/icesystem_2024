<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Salecom */

$this->title = 'แก้ไขรหัสคอมมิชชั่น: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'คอมมิชชั่น', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="salecom-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
