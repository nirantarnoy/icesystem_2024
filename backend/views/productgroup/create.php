<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Productgroup */

$this->title = Yii::t('app', 'สร้างกลุ่มสินค้า');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'กลุ่มสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '/'.$this->title;
?>
<div class="productgroup-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
