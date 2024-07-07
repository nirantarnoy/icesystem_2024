<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Deliveryroute */

$this->title = Yii::t('app', 'แก้ไขเส้นทางขนส่ง: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'เส้นทางขนส่ง'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '/'.Yii::t('app', 'แก้ไข');
?>
<div class="deliveryroute-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
