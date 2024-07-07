<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Paymentreceive */

$this->title = $model->journal_no;
$this->params['breadcrumbs'][] = ['label' => 'ชำระหนี้', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="paymentreceive-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //    'id',
            'trans_date',
            'journal_no',
            'customer_id',
            [
                'attribute' => 'customer_id',
                'value' => function ($data) {
                    return \backend\models\Customer::findName($data->customer_id);
                }
            ],
            [
                'label' => 'ยอดชำระ',
                'value' => function ($data) {
                    return \backend\models\Paymentreceive::findPayamt($data->id);
                }
            ]
//            'created_at',
//            'crated_by',
//            'updated_at',
//            'updated_by',
//            'status',
        ],
    ]) ?>

</div>
