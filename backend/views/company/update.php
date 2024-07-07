<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Company */

$this->title = Yii::t('app', 'ข้อมูลบริษัท: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ข้อมูลบริษัท'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = Yii::t('app', '');
?>
<div class="company-update">

    <?= $this->render('_form', [
        'model' => $model,
        'model_branch' => $model_branch,
    ]) ?>

</div>
