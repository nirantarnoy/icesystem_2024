<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pricegroup */

$this->title = Yii::t('app', 'แก้กลุ่มราคามาตรฐาน: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'กลุ่มราคามาตรฐาน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'แก้ไข');
?>
<div class="pricegroup-update">
    <?= $this->render('_form', [
        'model' => $model,
        'model_detail' => $model_detail,
        'model_customer_type'=>$model_customer_type
    ]) ?>

</div>
