<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Location */

$this->title = Yii::t('app', 'สร้าง Location');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Locations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
