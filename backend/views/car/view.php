<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Car */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ข้อมูลรถ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="car-view">

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
         //   'id',
            'code',
            'name',
            'description',
            [
                'attribute' => 'car_type_id',
                'value' => function ($data) {
                    return \backend\models\Cartype::findName($data->car_type_id);
                }
            ],
            [
                'attribute' => 'sale_group_id',
                'value' => function ($data) {
                    return \backend\models\Salegroup::findName($data->sale_group_id);
                }
            ],
            //'photo',
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

            'plate_number',
            'photo',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
