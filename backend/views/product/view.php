<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'รห้สสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '/' . $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">
    <p>
        <?= Html::a(Yii::t('app', 'แก้ไข'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'ลบ'), ['delete', 'id' => $model->id], [
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
            // 'id',
            'code',
            'name',
            'description',
            [
                'attribute' => 'product_type_id',
                'value' => function ($data) {
                    return \backend\models\Producttype::findName($data->product_type_id);
                }
            ],
            [
                'attribute' => 'product_group_id',
                'value' => function ($data) {
                    return \backend\models\Productgroup::findName($data->product_group_id);
                }
            ],
            'photo',
            'std_cost',
            'sale_price',
            [
                'attribute' => 'unit_id',
                'value' => function ($data) {
                    return \backend\models\Unit::findName($data->unit_id);
                }
            ],
//            'nw',
//            'gw',
//            'min_stock',
//            'max_stock',
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
//            'company_id',
//            'branch_id',
            [
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return date('d/m/Y H:i:s', $data->created_at);
                }
            ],
//            'updated_at',
//            'created_by',
//            'updated_by',
        ],
    ]) ?>

    <br>
    <div class="row">
        <div class="col-lg-12">
            <label for="">รูปสินค้า</label>
        </div>
    </div>
    <br>
    <div class="row">

        <div class="col-lg-4">
            <img src="../web/uploads/images/products/<?= $model->photo ?>" width="100%" alt="">
        </div>
        <div class="col-lg-4"></div>
        <div class="col-lg-4"></div>
    </div>

</div>
