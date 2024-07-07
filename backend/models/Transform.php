<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

date_default_timezone_set('Asia/Bangkok');

class Transform extends \common\models\JournalIssue
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
    public function findNum($id)
    {
        $model = \common\models\JournalIssue::find()->where(['id' => $id])->one();
        return $model != null ? $model->journal_no : '';
    }
//    public function findUnitid($code){
//        $model = Unit::find()->where(['name'=>$code])->one();
//        return count($model)>0?$model->id:0;
//    }

    public static function getLastNo($date, $company_id, $branch_id)
    {
        //   $model = Orders::find()->MAX('order_no');
        $model = Journalissue::find()->where(['date(trans_date)' => date('Y-m-d', strtotime($date))])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])->MAX('journal_no');

        $pre = "IS";
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

}
