<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Deliveryroute */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'เส้นทางขนส่ง'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '/'.$this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="deliveryroute-view">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
       //     'id',
            'code',
            'name',
            'description',
            'company_id',
            'branch_id',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
