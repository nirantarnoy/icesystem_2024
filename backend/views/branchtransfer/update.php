<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Branchtransfer */

$this->title = 'Update Branchtransfer: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Branchtransfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="branchtransfer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
