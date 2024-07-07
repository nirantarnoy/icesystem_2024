<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Assetsitem */

$this->title = 'สร้างรหัสอุปกรณ์';
$this->params['breadcrumbs'][] = ['label' => 'อุปกรณ์', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assetsitem-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelphoto'=> null,
    ]) ?>

</div>
