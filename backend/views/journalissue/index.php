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

$filename_car_pos = "empty";

$company_id = 1;
$branch_id = 1;
if (!empty(\Yii::$app->user->identity->company_id)) {
    $company_id = \Yii::$app->user->identity->company_id;
}
if (!empty(\Yii::$app->user->identity->branch_id)) {
    $branch_id = \Yii::$app->user->identity->branch_id;
}

if (!empty(\Yii::$app->session->getFlash('msg-index-car-pos')) && !empty(\Yii::$app->session->getFlash('after-save'))) {
    $f_name = \Yii::$app->session->getFlash('msg-index-car-pos');
    // echo $f_name;
//    if (file_exists('../web/uploads/slip_issue/' . $f_name)) {
//        $filename_car_pos = "../web/uploads/slip_issue/" . $f_name;
//    }
    if($branch_id == 1){
        if (file_exists('../web/uploads/company1/slip_issue/' . $f_name)) {
            $filename_car_pos = "../web/uploads/company1/slip_issue/" . $f_name;
        }
    }else if($branch_id == 2){
        if (file_exists('../web/uploads/company2/slip_issue/' . $f_name)) {
            $filename_car_pos = "../web/uploads/company2/slip_issue/" . $f_name;
        }
    }
}
?>
<div class="location-index">
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-lg-10">
            <p>
                <?php //echo Html::a(Yii::t('app', '<i class="fa fa-plus"></i> สร้างใหม่'), ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::a(Yii::t('app', '<i class="fa fa-cubes"></i> รายการเบิกแยกคัน'), ['issuebyroute'], ['class' => 'btn btn-info']) ?>
            </p>
        </div>
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
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'journal_no',
            [
                'attribute' => 'trans_date',
                'value' => function ($data) {
                    return date('d/m/Y H:i:s', strtotime($data->trans_date));
                }
            ],
            [
                'attribute' => 'delivery_route_id',
                'value' => function ($data) {
                    return \backend\models\Deliveryroute::findName($data->delivery_route_id);
                }
            ],
            [
                'attribute' => 'order_ref_id',
                'label'=>'เลขที่ขาย',
                'value' => function ($data) {
                    return \backend\models\Orders::getNumber($data->order_ref_id);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($data) {
                    if($data->status == 1){
                        return '<div class="badge badge-success">'.\backend\helpers\IssueStatus::getTypeById($data->status).'</div>';
                    }else if($data->status == 2){
                        return '<div class="badge badge-secondary">'.\backend\helpers\IssueStatus::getTypeById($data->status).'</div>';
                    }else{
                        return '<div class="badge badge-danger">'.\backend\helpers\IssueStatus::getTypeById($data->status).'</div>';
                    }

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
                'template' => '{view}{print}{update}{delete}',
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
                            '<span class="fas fa-print btn btn-xs btn-default"></span>', $url, $options);
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
    <div class="has-print-car-pos" data-var="<?= $filename_car_pos ?>">
        <input type="hidden" class="slip-print-car-pos" value="<?= $filename_car_pos ?>">
        <iframe id="iFramePdfCarPos" src="<?= $filename_car_pos ?>" style="display:none;"></iframe>
    </div>
</div>


<?php
$js=<<<JS
$(function (){
    var xx3 = $(".slip-print-car-pos").val();
     if(xx3 !="empty"){
          //  alert();
           myPrint3();
        }
});
function myPrint3(){
    var has_print_car_pos = $(".has-print-car-pos").attr("data-var");
   // alert(has_print_do);
    if(has_print_car_pos != "" || has_print_car_pos != null){
        var getMyFrame = document.getElementById('iFramePdfCarPos');
        getMyFrame.focus();
        getMyFrame.contentWindow.print();
    }
   
}
JS;
$this->registerJs($js,static::POS_END);
?>
