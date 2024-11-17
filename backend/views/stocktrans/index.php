<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StocktransSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ประวัติรับสินค้าเข้า-ออก คลัง';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocktrans-index">
    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel, 'f_date' => null, 't_date' => null]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'showPageSummary' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],],
            //  'id',
//            'company_id',
//            'branch_id',
            'journal_no',
            [
                'attribute' => 'trans_date',
                'value' => function ($data) {
                    return date('d/m/Y H:i:s', strtotime($data->trans_date));
                }
            ],
            [
                'attribute' => 'product_id',
                'value' => function ($data) {
                    return \backend\models\Product::findName($data->product_id);
                }
            ],
            [
                'attribute' => 'warehouse_id',
                'value' => function ($data) {
                    return \backend\models\Warehouse::findName($data->warehouse_id);
                }
            ],
            //'location_id',
            //'lot_no',
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
            [
               'label' => 'เลขที่อ้างอิง',
                'value'=> function($data){
                     if($data->activity_type_id  == 20){
                 //        return \backend\models\Transformreserv::findNum($data->trans_ref_id);
                         return \backend\models\Stocktrans::findProdrecNo($data->prodrec_id, $data->company_id, $data->branch_id);
                     }else if($data->activity_type_id  == 18){
                         return \backend\models\Stocktrans::findProdrecRefNo($data->id,$data->product_id);
                     }else{
                         return '';
                     }
                }
            ],
            [
                'attribute' => 'stock_type',
                'format' => 'html',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function ($data) {
                    if ($data->stock_type == 1) {
                        return '<div class="badge badge-success">IN</div>';
                    } else if ($data->stock_type == 2) {
                        return '<div class="badge badge-danger">OUT</div>';
                    }
                }
            ],
            [
                'attribute' => 'activity_type_id',
                'headerOptions' => ['style' => 'text-align: left'],
                'contentOptions' => ['style' => 'text-align: left'],
                'format' => 'html',
                'value' => function ($data) {
                    $font_color = '';
                    if ($data->activity_type_id == 28) {
                        $font_color = 'text-warning';
                    }
                    // return \backend\helpers\ActivityType::getTypeById($data->activity_type_id);
                    return '<div class="' . $font_color . '">' . \backend\helpers\RunnoTitle::getTypeById($data->activity_type_id) . '</div>';
                }
            ],
            [
                'attribute' => 'created_by',
                'label' => 'พนักงาน',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function ($data) {
                    return \backend\models\User::findName($data->created_by);
                }
            ],

            //'location_id',
            //'lot_no',
//            [
//                'attribute' => 'updated_at',
//                'value' => function ($data) {
//                    return date('d/m/Y H:i:s');
//                }
//            ],
            //'created_by',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
