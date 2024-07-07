<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StocktransSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายงานยอดรับเข้าผลิต';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocktrans-index">
    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel, 'f_date' => null, 't_date' => null]); ?>
    <br/>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'showPageSummary' => true,
        'toolbar' => [
            '{toggleData}',
            '{export}',
        ],
        'panel' => ['type' => 'info', 'heading' => 'รายงานยอดรับเข้าผลิต'],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn',
//                'headerOptions' => ['style' => 'text-align: center'],
//                'contentOptions' => ['style' => 'text-align: center'],],
            //  'id',
//            'company_id',
//            'branch_id',
            [
                'attribute' => 'product_id',
                'value' => function ($data) {
                    return \backend\models\Product::findName($data->product_id);
                },
            ],

            [
                'attribute' => 'qty',
                'headerOptions' => ['style' => 'text-align: right'],
                'contentOptions' => ['style' => 'text-align: right'],
                'value' => function ($data) {
                    return $data->qty;
                },
                'format' => ['decimal', 2],
                'hAlign' => 'right',
                'pageSummary' => true,
                'pageSummaryFunc' => GridView::F_SUM
            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
