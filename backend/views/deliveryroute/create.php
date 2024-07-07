<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Deliveryroute */

$this->title = Yii::t('app', 'สร้างเส้นทางขนส่ง');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'เส้นทางขนส่ง'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '/'.$this->title;
?>
<div class="deliveryroute-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
