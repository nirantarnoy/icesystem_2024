<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = Yii::t('app', 'สร้างรหัสสินค้า');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'สินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '/'.$this->title;
?>
<div class="product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
