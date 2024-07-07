<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

date_default_timezone_set('Asia/Bangkok');

class Plan extends \common\models\Plan
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

    public static function getLastNo($date, $company_id, $branch_id)
    {
        //   $model = Orders::find()->MAX('order_no');
        $model = Plan::find()->where(['date(trans_date)' => date('Y-m-d', strtotime($date))])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])->MAX('journal_no');

        $pre = "PL";
        if ($model != null) {
            $prefix = $pre . '-' . substr(date("Y"), 2, 2) . date('m', strtotime($date)) . date('d', strtotime($date)) . '-';
            $cnum = substr((string)$model, 10, strlen($model));
            $len = strlen($cnum);
            $clen = strlen($cnum + 1);
            $loop = $len - $clen;
            for ($i = 1; $i <= $loop; $i++) {
                $prefix .= "0";
            }
            $prefix .= $cnum + 1;
            return $prefix;
        } else {
            $prefix = $pre . '-' . substr(date("Y"), 2, 2) . date('m', strtotime($date)) . date('d', strtotime($date)) . '-';
            return $prefix . '0001';
        }
    }


    public function findNo($id){
        $model = Plan::find()->where(['id'=>$id])->one();
        return count($model)>0?$model->journal_no:'';
    }
//    public static function findName($id)
//    {
//        $model = Car::find()->select('name')->where(['id' => $id])->one();
//        return $model != null ? $model->name : '';
//    }
//
//    public static function findRouteId($id)
//    {
//        $model = \common\models\QueryCarRoute::find()->where(['id' => $id])->one();
//        return $model != null ? $model->delivery_route_id : 0;
//    }
//
//    public static function findRouteName($id)
//    {
//        $model = \common\models\QueryCarRoute::find()->where(['id' => $id])->one();
//        return $model != null ? $model->route_code : '';
//    }
//    public function findUnitid($code){
//        $model = Unit::find()->where(['name'=>$code])->one();
//        return count($model)>0?$model->id:0;
//    }

}
