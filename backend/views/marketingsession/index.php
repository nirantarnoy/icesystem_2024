<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\QueryMarketingSessionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายงานการตลาด';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="query-marketing-session-index">

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="col-lg-6" style="text-align: right;">
                    <div class="btn-group">
                        <?= Html::a('<i class="fa fa-file-excel"></i> Export Excel', ['export'] + Yii::$app->request->queryParams, ['class' => 'btn btn-success']) ?>
                        <button class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"></i> พิมพ์</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php Pjax::begin(); ?>
            <div class="search-form">
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                    'options' => ['data-pjax' => 1]
                ]); ?>
                <div class="row">
                    <div class="col-lg-2">
                        <?= $form->field($searchModel, 'from_date')->widget(\kartik\date\DatePicker::classname(), [
                            'options' => ['placeholder' => 'จากวันที่'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ])->label(false) ?>
                    </div>
                    <div class="col-lg-2">
                        <?= $form->field($searchModel, 'to_date')->widget(\kartik\date\DatePicker::classname(), [
                            'options' => ['placeholder' => 'ถึงวันที่'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ])->label(false) ?>
                    </div>
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
                    <div class="col-lg-4">
                        <?= Html::submitButton('<i class="fa fa-search"></i> ค้นหา', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fa fa-redo"></i> รีเซ็ต', ['index'], ['class' => 'btn btn-default']) ?>
                    </div>
                </div>
                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'login_date',
                        'label' => 'วันที่',
                        'value' => function($model){
                            return $model->login_date ? date('d/m/Y H:i:s', strtotime($model->login_date)) : '-';
                        }
                    ],
                    [
                        'attribute' => 'fname',
                        'label' => 'เจ้าหน้าที่ตลาด',
                        'value' => function($model){
                            return $model->fname . ' ' . $model->lname;
                        }
                    ],

                    [
                        'attribute' => 'route_name',
                        'label' => 'สาย',
                    ],
                    [
                        'label' => 'กิจกรรม',
                        'format' => 'raw',
                        'value' => function($model){
                            $date = date('Y-m-d', strtotime($model->login_date));
                            $activities = \backend\models\QueryMarketingSession::getActivities($model->user_id, $model->route_id, $date);
                            $html = '';
                            if($activities){
                                foreach($activities as $activity){
                                    $html .= '<span class="badge badge-success" style="margin-right: 5px;">' . $activity->activity_type . '</span>';
                                }
                            }
                            return $html;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{details}',
                        'buttons' => [
                            'details' => function($url, $model, $key){
                                $date = date('Y-m-d', strtotime($model->login_date));
                                return Html::a('<i class="fa fa-eye"></i> ดูรายละเอียด', ['details', 'user_id' => $model->user_id, 'route_name' => $model->route_name, 'date' => $date], ['class' => 'btn btn-info btn-sm']);
                            }
                        ]
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>

<style>
    @media print {
        .main-sidebar, .main-header, .card-header .btn-group, .filters {
            display: none !important;
        }
        .content-wrapper {
            margin-left: 0 !important;
        }
        .card {
            border: none !important;
        }
    }
</style>
