<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Customertype */

$this->title = Yii::t('app', 'แก้ไขประเภทลูกค้า: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ประเภทลูกค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'แก้ไข');
?>
<div class="customertype-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
