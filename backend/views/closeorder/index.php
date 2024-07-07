<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;

$this->title = Yii::t('app', 'ปิดใบสั่งขาย');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-lg-2" style="text-align: right">
            <form id="form-perpage" class="form-inline" action="<?= Url::to(['orders/index'], true) ?>"
                  method="post">
                <div class="form-group">
                    <label>แสดง </label>
                    <select class="form-control" name="perpage" id="perpage">
                        <option value="50" <?= $perpage == '50' ? 'selected' : '' ?>>50</option>
                        <option value="100" <?= $perpage == '100' ? 'selected' : '' ?> >100</option>
                        <option value="150" <?= $perpage == '150' ? 'selected' : '' ?>>150</option>
                    </select>
                    <label> รายการ</label>
                </div>
            </form>
        </div>
    </div>
    <br />
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'emptyCell' => '-',
        'layout' => "{items}\n{summary}\n<div class='text-center'>{pager}</div>",
        'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
        'showOnEmpty' => false,
        //    'bordered' => true,
        //     'striped' => false,
        //    'hover' => true,
        'id' => 'product-grid',
        //'tableOptions' => ['class' => 'table table-hover'],
        'emptyText' => '<div style="color: red;text-align: center;"> <b>ไม่พบรายการไดๆ</b> <span> เพิ่มรายการโดยการคลิกที่ปุ่ม </span><span class="text-success">"สร้างใหม่"</span></div>',
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
            ],
            'order_no',
            [
                'attribute' => 'order_date',
                'value' => function ($data) {
                    return date('d/m/Y', strtotime($data->order_date));
                }
            ],
//            [
//                'attribute' => 'customer_id',
//                'value' => function ($data) {
//                    return \backend\models\Customer::findName($data->customer_id);
//                }
//            ],
//            'customer_type',
//            'customer_name',
            [
                'attribute' => 'route_name',
            ],
            [
                'attribute' => 'qty',
                'headerOptions' => ['style' => 'text-align: right'],
                'contentOptions' => ['style' => 'text-align: right'],
                'value' => function($data){
                    return number_format($data->qty);
                }
            ],
            [
                'attribute' => 'sale_qty',
                'headerOptions' => ['style' => 'text-align: right'],
                'contentOptions' => ['style' => 'text-align: right'],
                'value' => function($data){
                    return number_format($data->sale_qty);
                }
            ],
            [
                'attribute' => 'avl_qty',
                'headerOptions' => ['style' => 'text-align: right'],
                'contentOptions' => ['style' => 'text-align: right'],
                'value' => function($data){
                    return number_format($data->avl_qty);
                }
            ],
            [

                'header' => 'ตัวเลือก',
                'headerOptions' => ['style' => 'text-align:center;', 'class' => 'activity-view-link',],
                'contentOptions' => ['style'=> 'text-align: center'],
                'format' => 'html',
                'value' => function($data){
                    return '<a href="'.Url::to(['closeorder/view'],true).'&id='.$data->id.'" class="btn btn-info btn-sm">จัดการ</a>';
                }
            ],
        ],
        'pager' => ['class' => LinkPager::className()],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
