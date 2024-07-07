<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Production */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'ใบสั่งผลิต', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="production-view">

    <p>
        <?= Html::a('แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('ลบ', ['delete', 'id' => $model->id], [
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
            'id',
            'prod_no',
            'prod_date',
            'plan_id',
            'status',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'company_id',
            'branch_id',
            'delivery_route_id',
        ],
    ]) ?>

</div>
