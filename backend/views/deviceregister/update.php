<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Deviceregister */

$this->title = 'แก้ไขลงทะเบียนอุปกรณ์: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'ลงทะเบียนอุปกรณ์', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="deviceregister-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
