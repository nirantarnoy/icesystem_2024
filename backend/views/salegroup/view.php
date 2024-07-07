<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Salegroup */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'กลุ่มการขาย'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="salegroup-view">
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
        //    'id',
            'code',
            'name',
            [
                'attribute' => 'delivery_route_id',
                'value' => function ($data) {
                    return \backend\models\Deliveryroute::findName($data->delivery_route_id);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->status == 1) {
                        return '<div class="badge badge-success">ใช้งาน</div>';
                    } else {
                        return '<div class="badge badge-secondary">ไม่ใช้งาน</div>';
                    }
                }
            ],
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
