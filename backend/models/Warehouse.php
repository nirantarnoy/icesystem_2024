<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

date_default_timezone_set('Asia/Bangkok');

class Warehouse extends \common\models\Warehouse
{
    public function behaviors()
    {
        return [
            'timestampcdate' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                ],
                'value' => time(),
            ],
            'timestampudate' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'updated_at',
                ],
                'value' => time(),
            ],
            'timestampcby' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_by',
                ],
                'value' => Yii::$app->user->id,
            ],
            'timestamuby' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
                ],
                'value' => Yii::$app->user->id,
            ],
//            'timestampcompany' => [
//                'class' => \yii\behaviors\AttributeBehavior::className(),
//                'attributes' => [
//                    ActiveRecord::EVENT_BEFORE_INSERT => 'company_id',
//                ],
//                'value' => isset($_SESSION['user_company_id']) ? $_SESSION['user_company_id'] : 1,
//            ],
//            'timestampbranch' => [
//                'class' => \yii\behaviors\AttributeBehavior::className(),
//                'attributes' => [
//                    ActiveRecord::EVENT_BEFORE_INSERT => 'branch_id',
//                ],
//                'value' => isset($_SESSION['user_branch_id']) ? $_SESSION['user_branch_id'] : 1,
//            ],
            'timestampupdate' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => time(),
            ],
        ];
    }

//    public function findUnitname($id){
//        $model = Unit::find()->where(['id'=>$id])->one();
//        return count($model)>0?$model->name:'';
//    }
    public static function findCode($id)
    {
        $model = Warehouse::find()->where(['id' => $id])->one();
        return $model != null ? $model->code : '';
    }
    public static function findName($id)
    {
        $model = Warehouse::find()->where(['id' => $id])->one();
        return $model != null ? $model->name : '';
    }
    public static function findWarehousecar($company_id, $branch_id){
        $model = Warehouse::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id,'is_warehouse_car'=>1])->one();
        return $model != null ? $model->id:0;
    }
    public static function findPrimary($company_id, $branch_id){
        $model = Warehouse::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id,'is_primary'=>1])->one();
        return $model != null ? $model->id:0;
    }

}
