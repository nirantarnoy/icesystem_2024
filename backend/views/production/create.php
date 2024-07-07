<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Production */

$this->title = 'สร้างใบสั่งผลิต';
$this->params['breadcrumbs'][] = ['label' => 'ใบสั่งผลิต', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="production-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model_line' => null,
    ]) ?>

</div>
