<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StocktransSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายงานขายเปรียบเทียบจ่าย';
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
        'panel' => ['type' => 'info', 'heading' => 'รายงานขายเปรียบเทียบจ่าย'],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
//        'rowOptions' => function($data){
//            if($data->issue_qty < $data->qty){
//                return ['class' => 'danger'];
//            }
//        },
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn',
//                'headerOptions' => ['style' => 'text-align: center'],
//                'contentOptions' => ['style' => 'text-align: center'],],
            //  'id',
//            'company_id',
//            'branch_id',
            [
                'attribute' => 'order_no',
                'label' => 'เลขที่ขาย',
                'width' => '310px',
                'value' => function ($model, $key, $index, $widget) {

                        return $model->order_no;

                },

                'group' => true,  // enable grouping
                'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                    $model_customer = \backend\models\Orders::find()->where(['order_no'=>$model->order_no, 'company_id'=>$model->company_id,'branch_id'=>$model->branch_id])->one();
                    $cust_id = 0;
                    $is_customer = 0;
                    $cust_name = '';
                    if($model_customer->customer_id == null){
                        $cus_id = $model_customer->order_channel_id;
                        $cust_name = \backend\models\Deliveryroute::findName($cust_id);
                    }else{
                        $cust_id = $model_customer->customer_id;
                        $cust_name = \backend\models\Customer::findName($cust_id);
                    }

                    return [
                        'mergeColumns' => [[0, 1]], // columns to merge in summary
                        'content' => [             // content to show in each summary cell
                            1 => 'ยอดรวม (' . $cust_name . ')',
                            2 => GridView::F_SUM,
                            3 => GridView::F_SUM,

                        ],
                        'contentFormats' => [      // content reformatting for each summary cell
                            2 => ['format' => 'number', 'decimals' => 2],
                            3 => ['format' => 'number', 'decimals' => 2],

                        ],
                        'contentOptions' => [      // content html attributes for each summary cell
                            1 => ['style' => 'font-variant:small-caps'],
                            2 => ['style' => 'text-align:right'],
                            3 => ['style' => 'text-align:right'],

                        ],
                        // html attributes for group summary row
                        'options' => ['class' => 'info table-info', 'style' => 'font-weight:bold;']
                    ];
                }
            ],
            [
                'attribute' => 'product_id',
                'label' => 'สินค้า',
                'width' => '250px',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->name;
                },
            ],
            [
                'attribute' => 'qty',
                'label' => 'จำนวนขาย',
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
            [
                'attribute' => 'issue_qty',
                'label' => 'จำนวนจ่าย',
                'headerOptions' => ['style' => 'text-align: right'],
                'contentOptions' => ['style' => 'text-align: right;'],
                'value' => function ($data, $key, $index) {
                        return $data->issue_qty == null ? 0 : $data->issue_qty;
                },
                'format' => ['decimal', 2],
                'hAlign' => 'right',
                'pageSummary' => true,
                'pageSummaryFunc' => GridView::F_SUM
            ],
            [
                'label' => 'สถานะการจ่าย',
                'format' => 'html',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'width' => '50px',
                'value' => function ($model, $key, $index, $widget) {
                    if($model->issue_qty == $model->qty){
                        return '<i class="fa fa-check-circle text-success text-lg"></i>';
                    }else{
                        return '<i class="fa fa-ban text-danger text-lg"></i>';
                    }
                },
            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>



</div>

<?php
function getQty($model, $product_id)
{
    $qty = 0;
    if ($model) {
        foreach ($model as $val) {
            if ($val->product_id == $product_id) {
                $qty += $val->qty;
            }
        }
    }
    return $qty;
}

?>
