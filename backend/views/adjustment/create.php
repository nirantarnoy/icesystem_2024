<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Adjustment */

$this->title = 'สร้างใบปรับสต๊อก';
$this->params['breadcrumbs'][] = ['label' => 'ปรับสต๊อก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adjustment-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
