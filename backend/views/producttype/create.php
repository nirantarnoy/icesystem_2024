<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Producttype */

$this->title = Yii::t('app', 'สร้างประเภทสินค้า');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ประเภทสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '/'.$this->title;
?>
<div class="producttype-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
