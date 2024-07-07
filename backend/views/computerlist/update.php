<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Computerlist */

$this->title = 'แก้ไขรายชื่อคอมพิวเตอร์: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'รายชื่อคอมพิวเตอร์', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="computerlist-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
