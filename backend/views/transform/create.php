<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Journalissue */

$this->title = 'สร้างใบเบิกแปรสภาพ';
$this->params['breadcrumbs'][] = ['label' => 'เบิกแปรสภาพ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journalissue-create">
    <?= $this->render('_form', [
        'model' => $model,
        'model_line' => null,
    ]) ?>

</div>
