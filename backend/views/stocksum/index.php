<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StocksumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'สินค้าคงคลัง';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocksum-index">
    <!--    <p>-->
    <!--        --><?php ////echo Html::a('Create Stocksum', ['create'], ['class' => 'btn btn-success']) ?>
    <!--    </p>-->

    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],],

            // 'id',
//            'company_id',
//            'branch_id',
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
            [
                'attribute' => 'qty',
                'headerOptions' => ['style' => 'text-align: right'],
                'contentOptions' => ['style' => 'text-align: right'],
                'value' => function ($data) {
                    return number_format($data->qty, 1);
                }
            ],
            [
                'attribute' => 'route_id',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function ($data) {
                    return \backend\models\Deliveryroute::findName($data->route_id);
                }
            ],
            //'lot_no',
            [
                'attribute' => 'updated_at',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function ($data) {
                    return date('d/m/Y H:i:s', $data->updated_at==null?$data->created_at: $data->updated_at);
                }
            ],
            //'created_at',

            //   ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
