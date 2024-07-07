<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Paymentreceive */

$this->title = 'บันทึกรับชำระหนี้';
$this->params['breadcrumbs'][] = ['label' => 'ชำระหนี้', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentreceive-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model_line'=> null
    ]) ?>

</div>
