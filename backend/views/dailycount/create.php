<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dailycount */

$this->title = 'Create Dailycount';
$this->params['breadcrumbs'][] = ['label' => 'Dailycounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dailycount-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
