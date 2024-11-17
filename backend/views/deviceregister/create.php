<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Deviceregister */

$this->title = 'สร้างลงทะเบียนอุปกรณ์';
$this->params['breadcrumbs'][] = ['label' => 'ลงทะเบียนอุปกรณ์', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deviceregister-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
