<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use lavrentiev\widgets\toastr\Notification;
use yii\bootstrap4\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SequenceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'ลำดับเอกสาร');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sequence-index">
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-lg-10">
            <div class="btn-group">
                <?= Html::a(Yii::t('app', '<i class="fa fa-plus"></i> สร้างใหม่'), ['create'], ['class' => 'btn btn-success']) ?>
                <div class="btn-group">
                    <div class="btn btn-primary btn-auto">
                        <i class="fa fa-adn"></i> สร้างอัตโนมัติ
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-2" style="text-align: right">
            <form id="form-perpage" class="form-inline" action="<?= Url::to(['producttype/index'], true) ?>"
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
    <div style="margin-top: 10px;"></div>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="table-responsive">

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
                [
                    'attribute' => 'module_id',
                    'contentOptions' => ['style' => 'vertical-align: middle'],
                    'value' => function ($data) {
                        return \backend\helpers\RunnoTitle::getTypeById($data->module_id);
                    }
                ],
                [
                    'attribute' => 'prefix',
                    'contentOptions' => ['style' => 'vertical-align: middle'],
                ],
                [
                    'attribute' => 'symbol',
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                ],
                //'use_year',
                //'use_month',
                //'use_day',
                [
                    'attribute' => 'minimum',
                    'headerOptions' => ['style' => 'text-align: right;'],
                    'contentOptions' => ['style' => 'vertical-align: middle;text-align: right;'],
                ],
                [
                    'attribute' => 'maximum',
                    'headerOptions' => ['style' => 'text-align: right;'],
                    'contentOptions' => ['style' => 'vertical-align: middle;text-align: right;'],
                ],
                [
                    'attribute' => 'currentnum',
                    'headerOptions' => ['style' => 'text-align: right;'],
                    'contentOptions' => ['style' => 'vertical-align: middle;text-align: right;'],
                ],
                [
                    'label' => 'รูปแบบ',
                    'headerOptions' => ['style' => 'text-align: left;'],
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                    'value' => function ($data) {
                        $full = "";
                        $use_year = "";
                        $use_month = "";
                        $use_day = "";
                        for ($i = 0; $i <= strlen($data->maximum) - 1; $i++) {
                            $full .= "0";
                        }
                        if ($data->use_year) {
                            $use_year = date('y');
                        }
                        if ($data->use_month) {
                            $use_month = date('y');
                        }
                        if ($data->use_day) {
                            $use_day = date('y');
                        }
                        return $data->prefix . $data->symbol . $use_year . $use_month . $use_day . $full;
                    }
                ],
                //'status',
                //'created_at',
                //'updated_at',
                //'created_by',
                //'updated_by',

                [
                    'attribute' => 'status',
                    'contentOptions' => ['style' => 'vertical-align: middle'],
                    'format' => 'html',
                    'value' => function ($data) {
                        return $data->status === 1 ? '<div class="label label-success">Active</div>' : '<div class="label label-default">Inactive</div>';
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
    </div>
</div>
</div>
<?php Pjax::end(); ?>
</div>
<?php
$url_to_gen = Url::to(['sequence/autogen'], true);
$this->registerJsFile('@web/js/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]], static::POS_END);
$this->registerCssFile('@web/css/sweetalert.css');
$this->registerJs('
         $(function(){
            $(".btn-auto").click(function(){
                swal({
                  title: "ยืนยัน",
                  text: "คุณต้องการให้ระบบสร้างเลขที่อัตโนมัติใช่หรือไม่",
                  type: "warning",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true
                }, function () {
                     $.ajax({
                        type: "post",
                        dataType: "html",
                        url: "' . $url_to_gen . '",
                        data: {autogen: 1},
                        success: function(data){
                          alert(data);
                        }
                     });
                });
            });
         });
         
            
', static::POS_END) ?>
