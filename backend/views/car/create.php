<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Car */

$this->title = Yii::t('app', 'สร้างข้อมูลรถ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ข้อมูลรถ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-create">
    <?= $this->render('_form', [
        'model' => $model,
        'emp_select_list' => []
    ]) ?>

</div>
