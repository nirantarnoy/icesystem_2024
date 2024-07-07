<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Computerlist */

$this->title = 'สร้างรายการ';
$this->params['breadcrumbs'][] = ['label' => 'รายชื่อคอมพิวเตอร์', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="computerlist-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
