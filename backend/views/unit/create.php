<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Unit */

$this->title = Yii::t('app', 'สร้างข้อมูลหน่วยนับ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'หน่วยนับ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
