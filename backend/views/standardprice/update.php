<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Standardprice */

$this->title = Yii::t('app', 'แก้ไขราคามาตรฐาน: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ราคามาตรฐาน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '/'.Yii::t('app', 'แก้ไข');
?>
<div class="standardprice-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
