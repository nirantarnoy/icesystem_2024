<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');

class Branch extends \common\models\Branch
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
//            'timestampcby'=>[
//                'class'=> \yii\behaviors\AttributeBehavior::className(),
//                'attributes'=>[
//                    ActiveRecord::EVENT_BEFORE_INSERT=>'created_by',
//                ],
//                'value'=> Yii::$app->user->identity->id,
//            ],
//            'timestamuby'=>[
//                'class'=> \yii\behaviors\AttributeBehavior::className(),
//                'attributes'=>[
//                    ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_by',
//                ],
//                'value'=> Yii::$app->user->identity->id,
//            ],
            'timestampupdate'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_at',
                ],
                'value'=> time(),
            ],
        ];
    }

    public static function findCode($id){
        $model = Branch::find()->where(['id'=>$id])->one();
        return $model != null?$model->code:'';
    }
    public static function findName($id){
        $model = Branch::find()->where(['id'=>$id])->one();
        return $model != null?$model->name:'';
    }
    public static function findLintoken($company_id,$id){
        $model = Branch::find()->where(['id'=>$id,'company_id'=>$company_id])->one();
        return $model != null?$model->line_token:'';
    }
//    public function findUnitid($code){
//        $model = Unit::find()->where(['name'=>$code])->one();
//        return count($model)>0?$model->id:0;
//    }

}
