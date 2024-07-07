<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Salecomcon */

$this->title = 'สร้างเงื่อนไขพิเศษ';
$this->params['breadcrumbs'][] = ['label' => 'เงื่อนไขพิเศษ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salecomcon-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
