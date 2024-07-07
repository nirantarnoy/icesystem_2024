<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = 'ประวัติการชำระเงิน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-index">

    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-lg-10">

        </div>
        <div class="col-lg-2"
             style="text-align: right">
            <form id="form-perpage"
                  class="form-inline"
                  action="<?= Url::to(['paymentrechistory/index'], true) ?>"
                  method="post">
                <div class="form-group">
                    <label>แสดง </label>
                    <select class="form-control"
                            name="perpage"
                            id="perpage">
                        <option value="20" <?= $perpage == '20' ? 'selected' : '' ?>>
                            20
                        </option>
                        <option value="50" <?= $perpage == '50' ? 'selected' : '' ?> >
                            50
                        </option>
                        <option value="100" <?= $perpage == '100' ? 'selected' : '' ?>>
                            100
                        </option>
                    </select>
                    <label>
                        รายการ</label>
                </div>
            </form>
        </div>
    </div>
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
            'journal_no',
            [
                'attribute' => 'created_at',
                'label'=>'วันที่ทำรายการ',
                'value' => function ($data) {
                    return date('d-m-Y H:i:s', $data->created_at);
                }
            ],
            'customer_code',
            'customer_name',
            [
                'label' => 'สายส่ง',
                'value' => function ($data) {
                    return \backend\models\Customer::findRoute($data->customer_id);
                }
            ],
            [
                'attribute' => 'payment_channel_id',
                'value' => function ($data) {
                    return $data->payment_channel_id == 1 ? 'เงินสด' : 'โอนธนาคาร';
                }
            ],
            [
                'attribute' => 'payment_amount',
                'headerOptions' => ['style' => 'text-align: right'],
                'contentOptions' => ['style' => 'text-align: right'],
                'value' => function ($data) {
                    return number_format($data->payment_amount);
                }
            ],
//            [
//
//                'header' => 'ตัวเลือก',
//                'headerOptions' => ['style' => 'text-align:center;', 'class' => 'activity-view-link',],
//                'class' => 'yii\grid\ActionColumn',
//                'contentOptions' => ['style' => 'text-align: center'],
//                'template' => '{view}',
//                'buttons' => [
//                    'view' => function ($url, $data, $index) {
//                        $options = [
//                            'title' => Yii::t('yii', 'View'),
//                            'aria-label' => Yii::t('yii', 'View'),
//                            'data-pjax' => '0',
//                        ];
//                        return Html::a(
//                            '<span class="fas fa-eye btn btn-xs btn-default"></span>', $url, $options);
//                    },
//                ]
//            ],
        ],
        'pager' => ['class' => LinkPager::className()],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
