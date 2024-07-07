<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Journalissue */

$this->title = 'สร้างใบเบิกเติมสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'ใบเบิกเติมสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journalissue-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
