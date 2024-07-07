<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Plan */

$this->title = 'สร้างแผนผลิต';
$this->params['breadcrumbs'][] = ['label' => 'แผนผลิต', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-create">


    <?= $this->render('_form', [
        'model' => $model,
        'model_line' => null,
    ]) ?>

</div>
