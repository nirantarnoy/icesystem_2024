<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Productgroup */

$this->title = Yii::t('app', 'แก้ไขกลุ่มสินค้า: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'กลุ่มสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '/'.Yii::t('app', 'แก้ไข');
?>
<div class="productgroup-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
