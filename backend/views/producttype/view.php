<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Producttype */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ประเภทสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '/'.$this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="producttype-view">

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
          //  'id',
            'code',
            'name',
            'description',
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

</div>
