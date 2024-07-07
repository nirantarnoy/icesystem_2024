<?php

namespace backend\models;

use common\models\Assets;
use Yii;
use yii\db\ActiveRecord;

date_default_timezone_set('Asia/Bangkok');

class Assetsitem extends \common\models\Assets
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

    public function findId($name)
    {
        $model = Assets::find()->where(['asset_name' => $name])->one();
        return $model != null ? $model->id : 0;
    }
    public function findIdFromCode($name)
    {
        $model = Assets::find()->where(['asset_no' => $name])->one();
        return $model != null ? $model->id : 0;
    }

    public static function findName($id)
    {
        $model = Assets::find()->select('asset_name')->where(['id' => $id])->one();
        return $model != null ? $model->asset_name : '';
    }
    public static function findFullName($id)
    {
        $model = Assets::find()->select(['asset_name','asset_no'])->where(['id' => $id])->one();
        return $model != null ? $model->asset_no.' '.$model->asset_name : '';
    }
    public static function findCode($id)
    {
        $model = Assets::find()->select('asset_no')->where(['id' => $id])->one();
        return $model != null ? $model->asset_no : '';
    }
    public static function findPrice($id)
    {
        $model = Assets::find()->select('rent_price')->where(['id' => $id])->one();
        return $model != null ? $model->rent_price : 0;
    }
    public static function findCustomername($id)
    {
        $model = \common\models\CustomerAsset::find()->where(['product_id' => $id])->one();
        return $model != null ? \backend\models\Customer::findName($model->customer_id) : '';
    }
    public static function findCustomerid($id)
    {
        $model = \common\models\CustomerAsset::find()->where(['product_id' => $id])->one();
        return $model != null ? $model->customer_id : 0;
    }

}
