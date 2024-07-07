<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Salecom */

$this->title = 'สร้างรหัสคอมมิชชั่น';
$this->params['breadcrumbs'][] = ['label' => 'คอมมิชชั่น', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salecom-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
