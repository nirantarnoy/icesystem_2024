<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Cardaily */

$this->title = 'Create Cardaily';
$this->params['breadcrumbs'][] = ['label' => 'Cardailies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cardaily-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
