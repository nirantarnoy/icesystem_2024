<?php
$company_id = 0;
$branch_id = 0;

if (empty(\Yii::$app->user->identity->company_id)) {
    //return $this->redirect(['site/logout']);
    return \Yii::$app->runAction('site/logout');
}
if (\Yii::$app->user->identity->company_id != null) {
    $company_id = \Yii::$app->user->identity->company_id;
} else {
    //  return $this->redirect(['site/logout']);
    return \Yii::$app->runAction('site/logout');
}
if (\Yii::$app->user->identity->branch_id != null) {
    $branch_id = \Yii::$app->user->identity->branch_id;
}

use yii\bootstrap4\Breadcrumbs;
use yii\web\Session;

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2><?= $this->title; ?></h2>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <?php
                    echo Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'options' => [
                            'class' => 'float-sm-right'
                        ]
                    ]);
                    ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content" style="padding: 15px;background-color: white">
        <div id="btn-show-alert"></div>
        <?php $session = \Yii::$app->session;
        if ($session->getFlash('msg')): ?>
            <input type="hidden" class="alert-msg" value="<?= $session->getFlash('msg'); ?>">
        <?php endif; ?>
        <?php if ($session->getFlash('msg-error')): ?>
            <input type="hidden" class="alert-msg-error" value="<?= $session->getFlash('msg-error'); ?>">
        <?php endif; ?>
        <form action="" id="form-delete" method="post"></form>


        <div id="secondLoginModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">

                    <form action="<?=\yii\helpers\Url::to(['site/addseconduser'],true)?>" method="post">
                        <div class="modal-header" style="background-color: #1aa67d">
                            <div class="row" style="text-align: center;width: 100%;color: white">
                                <div class="col-lg-12">
                                    <span><h3 class="popup-product"
                                              style="color: white">กำหนดพนักงานฝ่ายผลิต</h3></span>
                                    <input type="hidden" class="popup-product-id" value="">
                                    <input type="hidden" class="popup-product-code" value="">
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <br/>
                            <div class="label">พนักงานฝ่ายผลิต</div>
                            <?php
                            echo \kartik\select2\Select2::widget([
                                'name' => 'second_user_id',
                                'data' => \yii\helpers\ArrayHelper::map(\backend\models\User::find()->where(['status' => 1, 'company_id' => $company_id, 'branch_id' => $branch_id])->all(), 'id', 'username'),
                                'options' => [
                                    'placeholder' => '--เลือกพนักงาน--',
                                    'multiple' => true,
                                    'required' => true,
                                ],

                            ]);
                            ?>
                        </div>
                        <br/>
                        <div class="modal-footer">
                            <button class="btn btn-outline-success btn-add-cart" data-dismiss="modalx"><i
                                        class="fa fa-check"></i> ตกลง
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>


        <?= $content ?><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>


