<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Customerrequest */

$this->title = 'บันทึกการขาย (เปิดร้าน) : ' . $model->journal_no;
$this->params['breadcrumbs'][] = ['label' => 'บันทึกการขาย (เปิดร้าน)', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->journal_no, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="customerrequest-update">

    <?= $this->render('_form', [
        'model' => $model,
        'model_product' => $model_product,
        'model_doc' => $model_doc,
        'model_attach_select' => $model_attach_select
    ]) ?>

</div>
