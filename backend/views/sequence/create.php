<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Sequence */

$this->title = Yii::t('app', 'สร้างลำดับเอกสาร');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ลำดับเอกสาร'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sequence-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
