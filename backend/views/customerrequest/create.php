<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Customerrequest */

$this->title = 'บันทึกการขาย (เปิดร้าน)';
$this->params['breadcrumbs'][] = ['label' => 'บันทึกการขาย (เปิดร้าน)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customerrequest-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model_product' => null,
        'model_doc' => null,
        'model_attach_select' => null,
    ]) ?>

</div>
