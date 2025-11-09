<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StocktransSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายงานใบจ่ายสินค้า';
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
        'panel' => ['type' => 'info', 'heading' => 'รายงานใบจ่ายสินค้า'],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn',
//                'headerOptions' => ['style' => 'text-align: center'],
//                'contentOptions' => ['style' => 'text-align: center'],],
            //  'id',
//            'company_id',
//            'branch_id',
            [
                'attribute' => 'delivery_route_id',
                'width' => '310px',
                'value' => function ($model, $key, $index, $widget) {
                    if($model->delivery_route_id == null){
                        return $model->order_no;
                    }else{
                        return \backend\models\Deliveryroute::findName($model->delivery_route_id);
                    }

                },

                'group' => true,  // enable grouping
                'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                     $cust_id = \backend\models\Orders::find()->where(['id'=>$model->order_ref_id])->one();
                     $cust_name = \backend\models\Customer::findName($cust_id);
                    return [
                        'mergeColumns' => [[0, 3]], // columns to merge in summary
                        'content' => [             // content to show in each summary cell
                            1 => $model->delivery_route_id != null ? 'ยอดรวม (' . \backend\models\Deliveryroute::findName($model->delivery_route_id) . ')' : 'ยอดรวม '.$cust_name,
                            4 => GridView::F_SUM,

                        ],
                        'contentFormats' => [      // content reformatting for each summary cell
                            4 => ['format' => 'number', 'decimals' => 2],

                        ],
                        'contentOptions' => [      // content html attributes for each summary cell
                            1 => ['style' => 'font-variant:small-caps'],
                            4 => ['style' => 'text-align:right'],

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
//                'group' => true,  // enable grouping
//                'subGroupOf' => 0, // supplier column index is the parent group,
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
                'attribute' => 'temp_update',
                'label' => 'วันที่',
                'value' => function ($data) {
                    return date('d/m/Y H:i:s', strtotime($data->temp_update));
                },
                // 'group' => true,
                //'subGroupOf' => 0
            ],
            'journal_no',
            [
                'attribute' => 'prod_rec_no',
                'label' => 'เลขที่ใบรับเข้า',
                'value' => function ($data) {
                    return $data->prod_rec_no;
                },
                // 'group' => true,
                //'subGroupOf' => 0
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
    ]); ?>

    <?php Pjax::end(); ?>

    <div class="row">
        <div class="col-lg-12">
            <?php

            $data = [];
            foreach ($model_bottom as $value) {
                if (in_array($value->product_id, $data)) {
                    continue;
                } else {
                    array_push($data, $value->product_id);
                }

//                if(array_search($value->product_id, array_keys($data))){
//                  array_push($data,['product_id'=>$value->product_id,'qty'=>$value->qty]);
//                }
            }
            //  print_r($data);

            ?>
        </div>
    </div>
    <br/>
    <h4>
        สรุปจำนวน</h4>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered"
                   width="100%">
                <thead>
                <tr>
                    <?php for ($i = 0; $i <= count($data) - 1; $i++): ?>
                        <th style="width: 10%; text-align: center"><?= \backend\models\Product::findCode($data[$i]) ?></th>
                    <?php endfor; ?>
                    <th style="width: 10%; text-align: center">
                        รวมทั้งหมด
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php $total = 0; ?>
                    <?php for ($i = 0; $i <= count($data) - 1; $i++): ?>
                        <?php $total += getQty($model_bottom, $data[$i]); ?>
                        <td style="width: 10%; text-align: center"><?= number_format(getQty($model_bottom, $data[$i]),2) ?></td>
                    <?php endfor; ?>
                    <td style="width: 10%; text-align: center"><?= number_format($total,2) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align: right;">
            FM-WAT-03 แก้ไขครั้งที่: 01 <br />
            วันที่ประกาศใช้: 01/01/2565
        </div>
    </div>
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
