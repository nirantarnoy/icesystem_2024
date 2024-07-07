<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Adjustment */

$this->title = 'แก้ไขใบปรับสต๊อก: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'ปรับสต๊อก', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="adjustment-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
