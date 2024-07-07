<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Sequence */

$this->title = Yii::t('app', 'แก้ไขลำดับเอกสาร: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ลำดับเอกสาร'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sequence-update">
<?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
