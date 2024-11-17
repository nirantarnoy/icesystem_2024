<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Journalissue */

$this->title = $model->journal_no;
$this->params['breadcrumbs'][] = ['label' => 'ใบเบิก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="journalissue-view">
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
         //   'id',
            'journal_no',
            [
                'attribute' => 'trans_date',
                'value' => function ($data) {
                    return date('d/m/Y', strtotime($data->trans_date));
                }
            ],
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    return \backend\helpers\IssueStatus::getTypeById($data->status);
                }
            ],
//            'created_at',
//            'created_by',
//            'updated_at',
//            'updated_by',
        ],
    ]) ?>

</div>
