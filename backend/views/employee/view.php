<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Employee */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="employee-view">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'code',
            'fname',
            'lname',
            [
                'attribute' => 'gender',
                'value' => function ($data) {
                    return \backend\helpers\GenderType::getTypeById($data->gender);
                }
            ],
            [
                'attribute' => 'position',
                'value' => function ($data) {
                    return \backend\models\Position::findName($data->position);
                }
            ],
            [
                'attribute' => 'salary_type',
                'value' => function ($data) {
                    return \backend\helpers\SalaryType::getTypeById($data->salary_type);
                }
            ],
            'emp_start',
            'description',
            'photo',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->status == 1) {
                        return '<div class="badge badge-success">ใช้งาน</div>';
                    } else {
                        return '<div class="badge badge-secondary">ไม่ใช้งาน</div>';
                    }
                }
            ],

            'company_id',
            'branch_id',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
