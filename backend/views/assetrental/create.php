<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Assetrental */

$this->title = 'Create Assetrental';
$this->params['breadcrumbs'][] = ['label' => 'Assetrentals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assetrental-create">
    <?= $this->render('_form', [
        'model' => $model,
        'model_line' => null,
    ]) ?>

</div>
