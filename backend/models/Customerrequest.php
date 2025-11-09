<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

date_default_timezone_set('Asia/Bangkok');

class Customerrequest extends \common\models\CustomerRequest
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
    public static function getLastNo()
    {
        //   $model = Orders::find()->MAX('order_no');
        $model = Customerrequest::find()->MAX('journal_no');

        $pre = "";
        $m = date("m");
        if(strlen($m)==1){
            $m = '0'.$m;
        }
        $prefix = $pre.substr(date("Y"),2,2).$m;
        //if($branch_id==1){
        if ($model != null) {
//            $cnum = substr((string)$model,4,strlen($model));
//            $len = strlen($cnum);
//            $clen = strlen($cnum + 1);
//            $loop = $len - $clen;
         //   $prefix = $pre . '-' . substr(date("Y"), 2, 2);
            //  $prefix = $pre;
            $cnum = substr((string)$model, 4, strlen($model)); // omnoi
            // $cnum = substr((string)$model, 3, strlen($model));

            $len = strlen($cnum);
            $clen = strlen($cnum + 1);
            $loop = $len - $clen;
            for ($i = 1; $i <= $loop; $i++) {
                $prefix .= "0";
            }
            $prefix .= $cnum + 1;
            return $prefix;
        } else {
            //   $prefix = $pre . '-' . substr(date("Y"), 2, 2); // omnoi
           // $prefix = $pre;
            return $prefix . '001';
        }
        // }

    }

}
