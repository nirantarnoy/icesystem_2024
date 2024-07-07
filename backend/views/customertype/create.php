<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Customertype */

$this->title = Yii::t('app', 'สร้างประเภทลูกค้า');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ประเภทลูกค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customertype-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
