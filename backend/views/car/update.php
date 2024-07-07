<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Car */

$this->title = Yii::t('app', 'แก้ไขข้อมูลรถ: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ข้อมูรถ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="car-update">
    <?= $this->render('_form', [
        'model' => $model,
        'emp_select_list' => $emp_select_list
    ]) ?>

</div>
