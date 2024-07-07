<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = Yii::t('app', 'แก้ไขรหัสสินค้า: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ข้อมูลสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '/'.Yii::t('app', 'แก้ไข');
?>
<div class="product-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
