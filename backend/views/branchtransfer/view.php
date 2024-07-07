<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Branchtransfer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'โอนสินค้าระหว่างสาขา', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="branchtransfer-view">
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
            //  'id',
            'journal_no',
            'trans_date',
            'description',
            'status',
            [
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return date('d/m/Y H:i:s', $data->created_at);
                }
            ],
            'created_by',
          //  'updated_at',
          //  'updated_by',
        ],
    ]) ?>

</div>
