<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Production */

$this->title = 'แก้ไขใบสั่งผลิต: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'ใบสั่งผลิต', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="production-update">
    <?= $this->render('_form', [
        'model' => $model,
        'model_line'=>$model_line,
    ]) ?>

</div>
