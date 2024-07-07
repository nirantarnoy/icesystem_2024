<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Assetrental */

$this->title = 'Update Assetrental: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Assetrentals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="assetrental-update">

    <?= $this->render('_form', [
        'model' => $model,
        'model_line'=> $model_line,
    ]) ?>

</div>
