<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Branchtransfer */

$this->title = 'สร้างรายการโอนสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'โอนสินค้าระหว่างคลัง', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branchtransfer-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
