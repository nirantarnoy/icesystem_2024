<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Cartype */

$this->title = Yii::t('app', 'สร้างประเภทรถ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ประเภทรถ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '/'.$this->title;
?>
<div class="cartype-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
