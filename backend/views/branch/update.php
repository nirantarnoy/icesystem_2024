<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Branch */

$this->title = Yii::t('app', 'แก้ไขสาขา: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'สาขา'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '/'.Yii::t('app', 'แก้ไข');
?>
<div class="branch-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
