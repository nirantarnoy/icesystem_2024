<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Company */

$this->title = Yii::t('app', 'ข้อมูลบริษัท');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ข้อมูลบริษัท'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '/'.$this->title;
?>
<div class="company-create">
    <?= $this->render('_form', [
        'model' => $model,
        'model_branch' => null,
    ]) ?>

</div>
