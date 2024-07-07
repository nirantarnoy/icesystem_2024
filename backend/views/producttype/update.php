<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Producttype */

$this->title = Yii::t('app', 'แก้ไขประเภทสินค้า: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ประเภทสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '/'.Yii::t('app', 'แก้ไข');
?>
<div class="producttype-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
