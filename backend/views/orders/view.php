<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'คำสั่งซื้อ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="orders-view">
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
          //  'id',
            'order_no',
            'customer_id',
            'customer_type',
            'customer_name',
            [
                'attribute' => 'order_date',
                'value' => function ($data) {
                    return date('d/m/Y', strtotime($data->order_date));
                }
            ],
            'vat_amt',
            'vat_per',
            'order_total_amt',
           // 'emp_sale_id',
            [
                'attribute' => 'order_channel_id',
                'value' => function ($data) {
                    return \backend\models\Deliveryroute::findName($data->order_channel_id);
                }
            ],
            [
                'attribute' => 'car_ref_id',
                'value' => function ($data) {
                    return \backend\models\Car::findName($data->car_ref_id);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function ($data) {
                    if ($data->status == 1) {
                        return '<div class="badge badge-success">Open</div>';
                    } else {
                        return '<div class="badge badge-secondary">Closed</div>';
                    }
                }
            ],
//            'company_id',
//            'branch_id',
//            'created_at',
//            'updated_at',
//            'created_by',
//            'updated_by',
        ],
    ]) ?>

</div>
