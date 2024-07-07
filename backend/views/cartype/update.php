<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Cartype */

$this->title = Yii::t('app', 'แก้ไขประเภทรถ: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ประเภทรถ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '/'.Yii::t('app', 'แก้ไข');
?>
<div class="cartype-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
