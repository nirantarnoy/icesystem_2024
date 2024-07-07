<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Salegroup */

$this->title = Yii::t('app', 'สร้างกลุ่มการขาย');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'กลุ่มการขาย'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salegroup-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
