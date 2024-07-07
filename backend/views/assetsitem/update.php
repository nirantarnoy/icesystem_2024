<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Assetsitem */

$this->title = 'แก้ไขอุปกรณ์: ' . $model->asset_no;
$this->params['breadcrumbs'][] = ['label' => 'อุปกรณ์', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->asset_no, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="assetsitem-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelphoto'=> $modelphoto,
    ]) ?>

</div>
