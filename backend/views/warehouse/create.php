<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Warehouse */

$this->title = Yii::t('app', 'สร้างข้อมูลคลังสินค้า');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'คลังสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warehouse-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
