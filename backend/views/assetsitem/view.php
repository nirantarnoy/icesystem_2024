<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Assetsitem */

$this->title = $model->asset_no;
$this->params['breadcrumbs'][] = ['label' => 'อุปกรณ์', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="assetsitem-view">

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
           // 'id',
            'asset_no',
            'asset_name',
            'description',
            'status',
//            'company_id',
//            'branch_id',
//            'created_at',
//            'created_by',
//            'updated_at',
//            'updated_by',
        ],
    ]) ?>

</div>
