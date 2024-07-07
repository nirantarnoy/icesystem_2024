<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Location */

$this->title = Yii::t('app', 'แก้ไข Location: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Locations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'แก้ไข');
?>
<div class="location-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
