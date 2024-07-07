<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Branch */

$this->title = Yii::t('app', 'สร้างสาขา');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'สาขา'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model_has_company' => $model_has_company
    ]) ?>

</div>
