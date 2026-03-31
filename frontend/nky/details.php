<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\QueryMarketingSessionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $user_id int */
/* @var $route_name string */
/* @var $date string */
/* @var $officer_name string */

$this->title = 'รายงานการตลาด: ' . $officer_name . ' - ' . $route_name . ($date ? ' (' . date('d/m/Y', strtotime($date)) . ')' : '');
$this->params['breadcrumbs'][] = ['label' => 'รายงานการตลาด', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="query-marketing-session-details">

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="col-lg-6" style="text-align: right;">
                    <div class="btn-group">
                        <?= Html::a('<i class="fa fa-file-excel"></i> Export Excel', ['export', 'QueryMarketingSessionSearch[user_id]' => $user_id, 'QueryMarketingSessionSearch[route_name]' => $route_name], ['class' => 'btn btn-success']) ?>
                        <button class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"></i> พิมพ์</button>
                    </div>
                    <div class="print-time" style="display: none; font-size: 14px; font-weight: bold;">
                        พิมพ์เมื่อ: <?= date('d/m/Y H:i:s') ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php Pjax::begin(); ?>
            <div class="search-form">
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'action' => ['details', 'user_id' => $user_id, 'route_name' => $route_name, 'date' => $date],
                    'method' => 'get',
                    'options' => ['data-pjax' => 1]
                ]); ?>
                <div class="row">
                    <div class="col-lg-2">
                        <?= $form->field($searchModel, 'pageSize')->dropDownList([
                            '20' => '20',
                            '50' => '50',
                            '100' => '100',
                            'all' => 'All',
                        ], [
                            'class' => 'form-control',
                            'onchange' => 'this.form.submit()'
                        ])->label(false) ?>
                    </div>
                </div>
                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
            
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],


                    [
                        'attribute' => 'route_name',
                        'label' => 'สาย',
                    ],
                    [
                        'attribute' => 'shop_name',
                        'label' => 'ชื่อร้าน',
                    ],
                    [
                        'attribute' => 'activity_type',
                        'label' => 'ประเภทกิจกรรม',
                        'contentOptions' => ['style' => 'background-color: #ffff00;'],
                    ],
                    [
                        'attribute' => 'event_detail',
                        'label' => 'รายงานขาย',
                    ],
                    [
                        'attribute' => 'rent_borrow_tank',
                        'label' => 'ยืมถัง',
                        'format' => 'raw',
                        'value' => function($model){
                            return $model->rent_borrow_tank == 1 ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>';
                        }
                    ],
                    [
                        'attribute' => 'collect_tank',
                        'label' => 'เก็บถัง',
                        'format' => 'raw',
                        'value' => function($model){
                            return $model->collect_tank == 1 ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>';
                        }
                    ],
                    [
                        'label' => 'รูปภาพ',
                        'format' => 'raw',
                        'value' => function($model){
                            if ($model->photo_path) {
                                $photos = explode(',', $model->photo_path);
                                $html = '<div style="display: grid; grid-template-columns: repeat(2, 80px); gap: 5px; width: 165px;">';
                                foreach ($photos as $photo) {
                                    if (trim($photo) == '') continue;
                                    $thumbPath = Url::to(['marketingsession/thumb', 'name' => trim($photo)], true);
                                    $fullPath = Url::to('@web/uploads/marketing/' . trim($photo), true);
                                    $html .= Html::img($thumbPath, [
                                        'style' => 'width: 100%; aspect-ratio: 1/1; cursor: pointer; border: 1px solid #ddd; object-fit: cover;',
                                        'onclick' => 'window.open("' . $fullPath . '")'
                                    ]);
                                }
                                $html .= '</div>';
                                return $model->photo_path != '' ? $html : '-';
                            }
                            return '-';
                        }
                    ],
                
                    [
                        'attribute' => 'check_in_time',
                        'label' => 'เช็คอิน (Session)',
                    ],
                    [
                        'attribute' => 'check_out_time',
                        'label' => 'เช็คเอาท์ (Session)',
                    ],
                    [
                        'label' => 'เช็คอิน',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'no-print', 'style' => 'text-align: center;'],
                        'contentOptions' => ['class' => 'no-print', 'style' => 'text-align: center;'],
                        'value' => function($model){
                            if($model->check_in_lat && $model->check_in_long){
                                return Html::a('<i class="fa fa-map-marked-alt fa-2x text-primary"></i>', 'https://www.google.com/maps/search/?api=1&query=' . $model->check_in_lat . ',' . $model->check_in_long, ['target' => '_blank', 'title' => $model->check_in_lat . ',' . $model->check_in_long]);
                            }
                            return '-';
                        }
                    ],
                    [
                        'label' => 'เช็คเอาท์',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'no-print', 'style' => 'text-align: center;'],
                        'contentOptions' => ['class' => 'no-print', 'style' => 'text-align: center;'],
                        'value' => function($model){
                            if($model->check_out_lat && $model->check_out_long){
                                return Html::a('<i class="fa fa-map-marked-alt fa-2x text-danger"></i>', 'https://www.google.com/maps/search/?api=1&query=' . $model->check_out_lat . ',' . $model->check_out_long, ['target' => '_blank', 'title' => $model->check_out_lat . ',' . $model->check_out_long]);
                            }
                            return '-';
                        }
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>

<style>
    @media print {
        .print-time {
            display: block !important;
        }
        .main-sidebar, .main-header, .card-header .btn-group, .filters, .breadcrumb, .no-print {
            display: none !important;
        }
        .content-wrapper {
            margin-left: 0 !important;
        }
        .card {
            border: none !important;
        }
        .card-header {
            border-bottom: 1px solid #eee !important;
        }
    }
</style>
