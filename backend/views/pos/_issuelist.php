<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use chillerlan\QRCode\QRCode;
use yii\web\Response;

$this->title = 'เบิกสินค้า';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="location-index">
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-lg-10"></div>
        <div class="col-lg-2" style="text-align: right">
            <form id="form-perpage" class="form-inline" action="<?= Url::to(['location/index'], true) ?>"
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
    <?php echo $this->render('_searchissue', ['model' => $searchModel]); ?>

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
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'journal_no',
            [
                'attribute' => 'trans_date',
                'value' => function ($data) {
                    return date('d/m/Y', strtotime($data->trans_date));
                }
            ],
            [
                'attribute' => 'delivery_route_id',
                'value' => function ($data) {
                    return \backend\models\Deliveryroute::findName($data->delivery_route_id);
                }
            ],
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    return \backend\helpers\IssueStatus::getTypeById($data->status);
                }
            ],

            //'created_by',
            //'updated_at',
            //'updated_by',

            [

                'header' => 'ตัวเลือก',
                'headerOptions' => ['style' => 'text-align:center;', 'class' => 'activity-view-link',],
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'text-align: center'],
                'template' => '{updateissue}',
                'buttons' => [
                    'updateissue' => function ($url, $data, $index) {
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

                ]
            ],
        ],
        'pager' => ['class' => LinkPager::className()],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
