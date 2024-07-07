<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'สรุปสินค้าสั่งผลิตแยกสายส่ง';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-index">
    <?php Pjax::begin(); ?>
    
    <?php echo $this->render('route_summary_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'showPageSummary' => true,
        'toolbar' => [
            '{toggleData}',
            '{export}',
        ],
        'panel' => ['type' => 'info', 'heading' => ''],
        'pjax' => true,
        'striped' => true,
        'hover' => true,
        'emptyCell' => '-',
        'layout' => "{items}\n{summary}\n<div class='text-center'>{pager}</div>",
        'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
        'showOnEmpty' => false,
        //    'bordered' => true,
        //     'striped' => false,
        //    'hover' => true,
        'id' => 'product-grid',
        //'tableOptions' => ['class' => 'table table-hover'],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'emptyText' => '<div style="color: red;text-align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
        'columns' => [
            [
                'attribute' => 'route_id',
                'width' => '310px',
                'value' => function ($model, $key, $index, $widget) {
                    return \backend\models\Deliveryroute::findName($model->route_id);
                },

                'group' => true,  // enable grouping
                'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                    return [
                        'mergeColumns' => [[0, 1]], // columns to merge in summary
                        'content' => [             // content to show in each summary cell
                            1 => 'ยอดรวม (' . \backend\models\Deliveryroute::findName($model->route_id) . ')',
                            2 => GridView::F_SUM,

                        ],
                        'contentFormats' => [      // content reformatting for each summary cell
                            2 => ['format' => 'number', 'decimals' => 2],

                        ],
                        'contentOptions' => [      // content html attributes for each summary cell
                            1 => ['style' => 'font-variant:small-caps'],
                            2 => ['style' => 'text-align:right'],

                        ],
                        // html attributes for group summary row
                        'options' => ['class' => 'info table-info', 'style' => 'font-weight:bold;']
                    ];
                }
            ],
            [
                'attribute' => 'product_id',
                'width' => '250px',
                'value' => function ($model, $key, $index, $widget) {
                    return \backend\models\Product::findName($model->product_id);
                },
                'group' => true,  // enable grouping
                'subGroupOf' => 0, // supplier column index is the parent group,
//                'groupFooter' => function ($model, $key, $index, $widget) { // Closure method
//                    return [
//                        'mergeColumns' => [[1, 3]], // columns to merge in summary
//                        'content' => [              // content to show in each summary cell
//                            2 => 'ยอดรวม (' . \backend\models\Product::findName($model->product_id) . ')',
//                            4 => GridView::F_SUM,
//                        ],
//                        'contentFormats' => [      // content reformatting for each summary cell
//                            4 => ['format' => 'number', 'decimals' => 2],
//
//                        ],
//                        'contentOptions' => [      // content html attributes for each summary cell
//                            4 => ['style' => 'text-align:right'],
//
//                        ],
//                        // html attributes for group summary row
//                        'options' => ['class' => 'success table-success', 'style' => 'font-weight:bold;']
//                    ];
//                },
            ],

            [
                'attribute' => 'qty',
                'headerOptions' => ['style' => 'text-align: right'],
                'contentOptions' => ['style' => 'text-align: right'],
                'value' => function ($data, $key, $index) {
                    return $data->qty == null ? 0 : $data->qty;
                },
                'format' => ['decimal', 2],
                'hAlign' => 'right',
                'pageSummary' => true,
                'pageSummaryFunc' => GridView::F_SUM
            ],

        ],
      //  'pager' => ['class' => LinkPager::className()],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
