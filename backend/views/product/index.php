<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap4\LinkPager;

$this->title = Yii::t('app', 'รหัสสินค้า');
$this->params['breadcrumbs'][] = '/' . $this->title;

$company_id = 1;
$branch_id = 1;
if(isset($_SESSION['user_company_id'])){
    $company_id = $_SESSION['user_company_id'];
}
if(isset($_SESSION['user_branch_id'])){
    $branch_id = $_SESSION['user_branch_id'];
}

?>
<div class="product-index">
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-lg-10">
            <p>
                <?= Html::a(Yii::t('app', '<i class="fa fa-plus"></i> สร้างใหม่'), ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::a(Yii::t('app', '<i class="fa fa-upload"></i> นำเข้า'), null, ['class' => 'btn btn-info', 'onclick' => 'showupload($(this))']) ?>
                <?= Html::a(Yii::t('app', '<i class="fa fa-download"></i> นำออก Excel'), ['export'], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                <?= Html::a(Yii::t('app', '<i class="fa fa-print"></i> พิมพ์'), ['printdoc'], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
            </p>
        </div>
        <div class="col-lg-2" style="text-align: right">
            <form id="form-perpage" class="form-inline" action="<?= Url::to(['product/index'], true) ?>"
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
//            [
//                'class' => 'yii\grid\SerialColumn',
//                'headerOptions' => ['style' => 'text-align: center'],
//                'contentOptions' => ['style' => 'text-align: center'],
//            ],
            [
                'attribute' => 'item_pos_seq',
                'label' => '#',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
            ],

            //  'id',
            'code',
            'name',
              'description',
            [
                'attribute' => 'product_type_id',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function ($data) {
                    return \backend\models\Producttype::findName($data->product_type_id);
                }
            ],
            [
                'attribute' => 'product_group_id',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function ($data) {
                    return \backend\models\Productgroup::findName($data->product_group_id);
                }
            ],
            'nw',
            [
                'attribute' => 'stock_type',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function ($data) {
                    if ($data->stock_type == 1) {
                        return '<div class="badge badge-success">Yes</div>';
                    } else {
                        return '<div class="badge badge-secondary">No</div>';
                    }
                }
            ],
            [
                'attribute' => 'unit_id',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function ($data) {
                    return \backend\models\Unit::findName($data->unit_id);
                }
            ],
            [
                'attribute' => 'std_cost',
                'value' => function ($data) {
                    return number_format($data->std_cost);
                }
            ],
            [
                'attribute' => 'sale_price',
                'value' => function ($data) {
                    return number_format($data->sale_price);
                }
            ],
            //'unit_id',
            //'nw',
            //'gw',
            //'min_stock',
            //'max_stock',
            [
                'attribute' => 'sale_status',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align: center'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function ($data) {
                    if ($data->sale_status == 1) {
                        return '<div class="badge badge-success">ขาย</div>';
                    } else {
                        return '<div class="badge badge-secondary">ไม่ขาย</div>';
                    }
                }
            ],
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
                            'onclick' => 'recDelete2($(this));'
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

<div id="importModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-upload"></i> นำเข้ารายการสินค้า
                    <small id="items"></small>
                </h4>
            </div>
            <div class="modal-body">
                <?php $form_upload = ActiveForm::begin(['action' => 'index.php?r=product/importproduct', 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <div class="row">
                    <div class="col-lg-12">
                        <small class="text-info"> สามารถดาวน์โหลด template สำหรับการนำเข้าสินค้าโดยคลิก</small>
                        <a href="#"
                           style="text-decoration-style: dashed;text-decoration: underline;">ที่นี่</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <br/>

                        <?= $form_upload->field($modelupload, 'file')->fileinput(['class' => 'form-control', 'accept' => '.csv'])->label(false) ?>


                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">

                        <i class="fa fa-warning text-danger"></i>
                        <small class="text-danger"> ขนาดไฟล์ไม่เกิน 100 MB</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <input type="submit" class="btn btn-success" value="ตกลง">
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>

<?php
$url_to_delete_line = 'index.php?r=product/deleteline';
$js = <<<JS
 $(function (){
     
 });
 function showupload(e){
     $("#importModal").modal('show');
 }
 function recDelete2(e){
    var line_id = e.attr("data-var");
    if(line_id){
        swal({
                title: "ต้องการลบรายการใช่หรือไม่?",
                text: "การยืนยันการลบครั้งนี้จะทำให้ข้อมูลหายไปจากระบบ",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
                showLoaderOnConfirm: true
               }, function () {
                   $.ajax({
                       'type': 'post',
                       'dataType': 'html',
                       'url': "$url_to_delete_line",
                       'data': {'id': line_id},
                       'success': function(data){
                           if(data ==1){
                               showAlert('success','ทำรายการสำเร็จ');
                               location.reload();
                           }else{
                               showAlert('error','พบข้อผิดพลาด');
                               location.reload();
                           }
                       }       
                    })    
         });
    }
    
}
JS;
$this->registerJs($js, static::POS_END);
?>
