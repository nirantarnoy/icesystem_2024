<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\DailycountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dailycounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dailycount-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Dailycount', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'trans_date',
            'product_id',
            'qty',
            'status',
            //'company_id',
            //'branch_id',
            //'user_id',
            //'warehouse_id',
            //'journal_no',
            //'posted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
