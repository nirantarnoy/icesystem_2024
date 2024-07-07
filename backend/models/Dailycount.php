<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');

class Dailycount extends \common\models\DailyCountStock
{
    public function behaviors()
    {
        return [
            'timestampcdate'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>'created_at',
                ],
                'value'=> time(),
            ],
            'timestampudate'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>'updated_at',
                ],
                'value'=> time(),
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
//    public static function findId($name){
//        $model = Deliveryroute::find()->select('id')->where(['name'=>$name])->one();
//        return $model != null?$model->id:0;
//    }
//    public static function findCode($id){
//        $model = Deliveryroute::find()->select('name')->where(['id'=>$id])->one();
//        return $model != null?$model->code:'';
//    }
//    public static function findRoutecode($id){
//        $model = Deliveryroute::find()->select('code')->where(['id'=>$id])->one();
//        return $model != null?$model->code:'';
//    }
//    public static function findName($id){
//        $model = Deliveryroute::find()->select('name')->where(['id'=>$id])->one();
//        return $model != null?$model->name:'';
//    }
//    public static function countCust($id){
//        $model = \backend\models\Customer::find()->where(['delivery_route_id'=>$id])->count();
//        return $model != null?$model:0;
//    }
//    public static function findRouteType($id){
//        $model = Deliveryroute::find()->select('type_id')->where(['id'=>$id])->one();
//        return $model != null?$model->type_id: 1;
//    }
//    public function findUnitid($code){
//        $model = Unit::find()->where(['name'=>$code])->one();
//        return count($model)>0?$model->id:0;
//    }

}
