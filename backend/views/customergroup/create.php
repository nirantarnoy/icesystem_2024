<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Customergroup */

$this->title = Yii::t('app', 'สร้างกลุ่มลูกค้า');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ประเภทลูกค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '/'.$this->title;
?>
<div class="customergroup-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
