<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pricegroup */

$this->title = Yii::t('app', 'สร้างกลุ่มราคามาตรฐาน');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'กลุ่มราคามาตรฐาน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pricegroup-create">
    <?= $this->render('_form', [
        'model' => $model,
        'model_detail' => null,
         'model_customer_type'=>null
    ]) ?>

</div>
