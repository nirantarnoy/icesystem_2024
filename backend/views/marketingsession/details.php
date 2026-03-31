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

$this->title = 'รายละเอียดการตลาด: ' . $route_name . ($date ? ' (' . date('d/m/Y', strtotime($date)) . ')' : '');
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
                        'attribute' => 'id',
                        'label' => 'เลขที่',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'วันที่',
                        'value' => function($model){
                            return date('d/m/Y H:i:s', strtotime($model->created_at));
                        }
                    ],
                    [
                        'attribute' => 'fname',
                        'label' => 'เจ้าหน้าที่ตลาด',
                        'value' => function($model){
                            return '(' . $model->username . ') ' . $model->fname . ' ' . $model->lname;
                        }
                    ],
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
                                $path = Url::to('@web/uploads/marketing/' . $model->photo_path, true);
                                return Html::img($path, ['style' => 'width: 100px; cursor: pointer;', 'onclick' => 'window.open(this.src)']);
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
                        'label' => 'พิกัดเช็คอิน',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'no-print'],
                        'contentOptions' => ['class' => 'no-print'],
                        'value' => function($model){
                            if($model->check_in_lat && $model->check_in_long){
                                return Html::a($model->check_in_lat . ',' . $model->check_in_long, 'https://www.google.com/maps/search/?api=1&query=' . $model->check_in_lat . ',' . $model->check_in_long, ['target' => '_blank']);
                            }
                            return '-';
                        }
                    ],
                    [
                        'label' => 'พิกัดเช็คเอาท์',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'no-print'],
                        'contentOptions' => ['class' => 'no-print'],
                        'value' => function($model){
                            if($model->check_out_lat && $model->check_out_long){
                                return Html::a($model->check_out_lat . ',' . $model->check_out_long, 'https://www.google.com/maps/search/?api=1&query=' . $model->check_out_lat . ',' . $model->check_out_long, ['target' => '_blank']);
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
