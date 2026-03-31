<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AssetsitemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'อุปกรณ์';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assetsitem-index">

    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-lg-10">
            <p>
                <?= Html::a(Yii::t('app', '<i class="fa fa-plus"></i> สร้างใหม่'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-lg-2" style="text-align: right">
            <form id="form-perpage" class="form-inline" action="<?= Url::to(['assetsitem/index'], true) ?>"
                  method="post">
                <div class="form-group">
                    <label>แสดง </label>
                    <select class="form-control" name="perpage" id="perpage">
                        <option value="20" <?= $perpage == '20' ? 'selected' : '' ?>>20</option>
                        <option value="50" <?= $perpage == '50' ? 'selected' : '' ?> >50</option>
                        <option value="100" <?= $perpage == '100' ? 'selected' : '' ?>>100</option>
                    </select>
                    <label> รายการ</label>
                </div>
            </form>
        </div>
    </div>
    <?php echo $this->render('_search', ['model' => $searchModel, 'viewstatus' => $viewstatus,'viewstatus2' => $viewstatus2]); ?>

    <div class="row" style="margin-top: 10px; margin-bottom: 15px;">
        <div class="col-lg-12">
            <div class="card card-body shadow-sm" style="background-color: #f4f6f9; border-left: 5px solid #17a2b8;">
                <div class="row align-items-center">
                    <div class="col-md-3 border-right text-center">
                        <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: bold;">จำนวนทั้งหมด</h6>
                        <h3 class="font-weight-bold text-info mb-0"><?= number_format($totalCount) ?></h3>
                        <small class="text-muted">รายการที่เลือก</small>
                    </div>
                    <div class="col-md-9">
                        <div class="d-flex flex-wrap justify-content-start align-items-center">
                            <h6 class="w-100 text-muted text-uppercase mb-2" style="font-size: 0.75rem; font-weight: bold; padding-left: 10px;">แยกตามรหัสตัวแรก:</h6>
                            <?php foreach ($prefixGroups as $prefix => $count): ?>
                                <div class="px-3 py-1 m-1 bg-white border rounded shadow-sm text-center" style="min-width: 100px; position: relative;">
                                    <span class="d-block text-muted" style="font-size: 0.7rem;">รหัส <strong>"<?= Html::encode($prefix) ?>"</strong></span>
                                    <span class="d-block font-weight-bold" style="font-size: 1.1rem; color: #333;"><?= number_format($count) ?></span>
                                    <a href="<?= Url::to(['assetsitem/export-stock-check', 'prefix' => $prefix, 'viewstatus' => $viewstatus, 'viewstatus2' => $viewstatus2]) ?>" class="btn btn-xs btn-outline-success mt-1" title="Export เฉพาะกลุ่มนี้">
                                        <i class="fas fa-file-excel"></i> Export
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-md-1 text-right">
                         <a href="<?= Url::to(['assetsitem/export-stock-check', 'viewstatus' => $viewstatus, 'viewstatus2' => $viewstatus2]) ?>" class="btn btn-sm btn-success shadow-sm" title="Export ทั้งหมด">
                            <i class="fas fa-file-excel"></i> Export ทั้งหมด
                         </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'emptyCell' => '-',
        'toolbar' => [
            '{toggleData}',
            '{export}',
        ],
        'panel' => ['type' => 'info', 'heading' => ''],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
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
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => ['style' => 'text-align: center'],
            ],
            'asset_no',
            'asset_name',
            'description',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function ($data) {
                    if ($data->status == 1) {
                        return '<div class="badge badge-success">ใช้งาน</div>';
                    } else {
                        return '<div class="badge badge-secondary">ไม่ใช้งาน</div>';
                    }
                }
            ],
            [
                //'attribute' => 'contact_no',
                'label' => 'เลขที่สัญญา',
                'value' => function ($data) {
                    return \backend\models\Assetsitem::findCustomerContract($data->id);
                  //  return $data->contact_no;
                }
            ],
            [
                'attribute' => 'customer_id',
                'label' => 'รหัสลูกค้า',
                'value' => function ($data) {
                    return \backend\models\Assetsitem::findCustomerCode($data->id);
                }
            ],
            [
                'attribute' => 'customer_id',
                'label' => 'ลูกค้า',
                'value' => function ($data) {
                    return \backend\models\Assetsitem::findCustomername($data->id);
                }
            ],
            [
                'attribute' => 'route_num',
                'label' => 'ลำดับการส่ง',
                'value' => function ($data) {
                    return $data->route_num;
                }
            ],
            [
                'label' => 'สายส่ง',
                'value' => function ($data) {
                    $customer_id = \backend\models\Assetsitem::findCustomerid($data->id);
                    return \backend\models\Customer::findRoute($customer_id);
                }
            ],
            [

                'header' => 'ตัวเลือก',
                'headerOptions' => ['style' => 'text-align:center;', 'class' => 'activity-view-link',],
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'text-align: center'],
                'template' => '{view} {update}{delete}',
                'buttons' => [
                    'view' => function ($url, $data, $index) {
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ];
                        return Html::a(
                            '<span class="fas fa-eye btn btn-xs btn-default"></span>', $url, $options);
                    },
                    'update' => function ($url, $data, $index) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'id' => 'modaledit',
                        ]);
                        return Html::a(
                            '<span class="fas fa-edit btn btn-xs btn-default"></span>', $url, [
                            'id' => 'activity-view-link',
                            //'data-toggle' => 'modal',
                            // 'data-target' => '#modal',
                            'data-id' => $index,
                            'data-pjax' => '0',
                            // 'style'=>['float'=>'rigth'],
                        ]);
                    },
                    'delete' => function ($url, $data, $index) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            //'data-method' => 'post',
                            //'data-pjax' => '0',
                            'data-url' => $url,
                            'data-var' => $data->id,
                            'onclick' => 'recDelete($(this));'
                        ]);
                        return Html::a('<span class="fas fa-trash-alt btn btn-xs btn-default"></span>', 'javascript:void(0)', $options);
                    }
                ]
            ],
        ],
        'pager' => ['class' => LinkPager::className()],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
<form action="<?= Url::to(['assetsitem/import-asset']) ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="file_asset">
    <button class="btn btn-info">import</button>
</form>
<br/>
<form action="<?= Url::to(['assetsitem/import-asset-by-customer']) ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="file_asset_customer">
    <button class="btn btn-info">import asset customer</button>
</form>

<br/>
<form action="<?= Url::to(['assetsitem/import-asset-updateprice']) ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="file_asset_update">
    <button class="btn btn-info">import update rent price</button>
</form>
