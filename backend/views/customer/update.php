<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Customer */

$this->title = Yii::t('app', 'แก้ไขรหัสลูกค้า: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ลูกค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'แก้ไข');
?>
<div class="customer-update">
    <?= $this->render('_form', [
        'model' => $model,
        'model_asset_list' =>$model_asset_list,
    ]) ?>

</div>
