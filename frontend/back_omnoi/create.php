<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Customerinvoice */

$this->title = 'สร้างใบวางบิล';
$this->params['breadcrumbs'][] = ['label' => 'วางบิล', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customerinvoice-create">
    <?= $this->render('_form', [
        'model' => $model,
        'model_line' => null,
    ]) ?>

</div>
