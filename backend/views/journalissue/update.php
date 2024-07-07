<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Journalissue */

$this->title = 'แก้ไขใบเบิก: ' . $model->journal_no;
$this->params['breadcrumbs'][] = ['label' => 'ใบเบิก', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->journal_no, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="journalissue-update">
    <?= $this->render('_form', [
        'model' => $model,
        'model_line' => $model_line
    ]) ?>

</div>
