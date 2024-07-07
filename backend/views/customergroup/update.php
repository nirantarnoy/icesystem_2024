<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Customergroup */

$this->title = Yii::t('app', 'แก้ไขกลุ่มลูกค้า: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'กลุ่มลูกค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'แก้ไข');
?>
<div class="customergroup-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
