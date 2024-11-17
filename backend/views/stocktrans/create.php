<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Stocktrans */

$this->title = 'Create Stocktrans';
$this->params['breadcrumbs'][] = ['label' => 'Stocktrans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocktrans-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
