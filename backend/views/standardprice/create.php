<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Standardprice */

$this->title = Yii::t('app', 'สร้างราคามาตรฐาน');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ราคามาตรฐาน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '/'.$this->title;
?>
<div class="standardprice-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
