<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Salegroup */

$this->title = Yii::t('app', 'แก้ไขกลุ่มการขาย: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'กลุ่มการขาย'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'แก้ไข');
?>
<div class="salegroup-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
