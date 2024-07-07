<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Branch */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'สาขา'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="branch-view">
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
            [
                'attribute' => 'company_id',
                'value' => function ($data) {
                    return \backend\models\Company::findName($data->company_id);
                }
            ],
            'code',
            'name',
            'description',
            'logo',
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
            [
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return date('d/m/Y H:i:s', strtotime($data->created_at));
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($data) {
                    return date('d/m/Y H:i:s', strtotime($data->updated_at));
                }
            ],
//            'created_by',
//            'updated_by',
        ],
    ]) ?>

</div>
