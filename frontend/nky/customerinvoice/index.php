<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'วางบิล';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customerinvoice-index">
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-lg-10">
            <p>
                <?= Html::a(Yii::t('app', '<i class="fa fa-plus"></i> สร้างใหม่'), ['create'], ['class' => 'btn btn-success']) ?>
                <div class="btn btn-warning btn-close-job-selected" style="display: none;"><i class="fa fa-check"></i> จบงานรายการที่เลือก</div>
            </p>
        </div>
        <div class="col-lg-2" style="text-align: right">
            <form id="form-perpage" class="form-inline" action="<?= Url::to(['customerinvoice/index'], true) ?>"
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
                'class' => 'yii\grid\CheckboxColumn',
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => ['style' => 'text-align: center'],
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    if ($model->status == 100) {
                        return ['value' => $model->id, 'class' => 'checkbox-row', 'disabled' => 'disabled'];
                    }
                    return ['value' => $model->id, 'class' => 'checkbox-row'];
                }
            ],
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => ['style' => 'text-align: center'],
            ],
            'journal_no',
            [
                'attribute' => 'trans_date',
                'value' => function ($data) {
                    return date('d/m/Y', strtotime($data->trans_date));
                }
            ],
            [
                'attribute' => 'customer_id',
                'value' => function ($data) {
                    return \backend\models\Customer::findName($data->customer_id);
                }
            ],
            [
                'attribute' => 'amount',
                'headerOptions' => ['style' => 'text-align: right;'],
                'contentOptions' => ['style' => 'text-align: right'],
                'label' => 'ยอดเงิน',
                'value' => function ($data) {
                    return number_format(\backend\models\Customerinvoice::getInvAmount($data->id),2);
                }
            ],
            [
                'attribute' => 'created_by',
                'label' => 'ดำเนินการโดย',
                'value' => function ($data) {
                    return \backend\models\User::findName($data->created_by);
                }
            ],
            [
                'attribute' => 'close_job_date',
                'label' => 'วันที่จบงาน',
                'value' => function ($data) {
                    return $data->close_job_date != null ? date('d/m/Y H:i:s', strtotime($data->close_job_date)) : '-';
                }
            ],
            [

                'header' => 'ตัวเลือก',
                'headerOptions' => ['style' => 'text-align:center;', 'class' => 'activity-view-link',],
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'text-align: center'],
                'template' => '{view} {print} {update} {closejob} {delete}',
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
                    'print' => function ($url, $data, $index) {
                        $options = [
                            'title' => Yii::t('yii', 'Print'),
                            'aria-label' => Yii::t('yii', 'Print'),
                            'data-pjax' => '0',
                        ];
                        return Html::a(
                            '<span class="fas fa-list-alt btn btn-xs btn-default"></span>', $url, $options);
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
                    'closejob' => function ($url, $data, $index) {
                        if ($data->status == 100) {
                            return Html::a(
                                '<span class="fas fa-check-circle btn btn-xs btn-success"></span>', 'javascript:void(0)', [
                                'title' => 'จบงานแล้ว',
                                'class' => 'disabled',
                                'style' => 'cursor: not-allowed;'
                            ]);
                        }
                        return Html::a(
                            '<span class="fas fa-check btn btn-xs btn-warning"></span>', ['closejob', 'id' => $data->id], [
                            'title' => 'จบงาน',
                            'data-confirm' => 'ยืนยันการจบงาน?',
                            'data-method' => 'post',
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

<?php
$url_to_close_job = Url::to(['customerinvoice/closejob-selected'], true);
$js = <<<JS
 $(document).on('change', '.checkbox-row, .select-on-check-all', function() {
    var keys = $("#product-grid").yiiGridView("getSelectedRows");
    if(keys.length > 0){
        $(".btn-close-job-selected").show();
    }else{
        $(".btn-close-job-selected").hide();
    }
 });

 $(document).on('click', '.btn-close-job-selected', function() {
    var keys = $("#product-grid").yiiGridView("getSelectedRows");
    if(keys.length > 0){
        if(confirm("ยืนยันการจบงานรายการที่เลือก?")){
            var form = $('<form action="$url_to_close_job" method="post"></form>');
            keys.forEach(function(key) {
                form.append('<input type="hidden" name="ids[]" value="' + key + '">');
            });
            $('body').append(form);
            form.submit();
        }
    }
 });
JS;
$this->registerJs($js);
?>
