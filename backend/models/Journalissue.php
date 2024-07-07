<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

date_default_timezone_set('Asia/Bangkok');

class Journalissue extends \common\models\JournalIssue
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
    public static function findNum($id)
    {
        $model = \common\models\JournalIssue::find()->where(['id' => $id])->one();
        return $model != null ? $model->journal_no : '';
    }

    public static function findId($journal_no)
    {
        $model = \common\models\JournalIssue::find()->where(['journal_no' => $journal_no])->one();
        return $model != null ? $model->id : 0;
    }

    public static function findPlan($id)
    {
        $model = Journalissue::find()->where(['plan_id' => $id])->one();
        return $model != null ? $model->journal_no : '';
    }

    public static function getLastNo($date, $company_id, $branch_id)
    {
        //   $model = Orders::find()->MAX('order_no');
        $model = Journalissue::find()->where(['date(trans_date)' => date('Y-m-d', strtotime($date))])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])->andFilterWhere(['!=', 'reason_id', 4])->MAX('journal_no');


       // $model = Journalissue::find()->select('journal_no')->where(['date(trans_date)' => date('Y-m-d', strtotime($date))])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])->andFilterWhere(['!=', 'reason_id', 4])->orderBy(['id'=>SORT_DESC])->one();

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

    public function getJournalissueline()
    {
        return $this->hasMany(\common\models\JournalIssueLine::className(), ['issue_id' => 'id']);
    }

    public static function getLastReprocessNo($date, $company_id, $branch_id)
    {
        //   $model = Orders::find()->MAX('order_no');
        $model = Journalissue::find()->where(['date(trans_date)' => date('Y-m-d', strtotime($date))])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id, 'reason_id' => 4])->MAX('journal_no');

        $model_seq = \backend\models\Sequence::find()->where(['module_id' => 20, 'company_id' => $company_id, 'branch_id' => $branch_id])->one();
        //$pre = \backend\models\Sequence::find()->where(['module_id'=>15])->one();
        $pre = '';
        $prefix = '';
        if ($model_seq) {
            $pre = $model_seq->prefix . $model_seq->symbol;
            if ($model) {
                if ($model_seq->use_year) {
                    $prefix = $pre . substr(date("Y"), 2, 2);
                }
                if ($model_seq->use_month) {
                    $m = date('m');
                    //if($m < 10){$m="0".$m;}
                    $prefix = $prefix . $m;
                }
                if ($model_seq->use_day) {
                    $d = date('d');
                    //if($d < 10){$d="0".$d;}
                    $prefix = $prefix . $d;
                }
                $prefix = $prefix . '-';
                $seq_len = strlen($prefix);
                $cnum = substr((string)$model, $seq_len, strlen($model));
                $len = strlen($model_seq->maximum);// strlen($cnum);
                $clen = strlen($cnum + 1);
                $loop = $len - $clen;
                for ($i = 1; $i <= $loop; $i++) {
                    $prefix .= "0";
                }
                $prefix .= $cnum + 1;
                return $prefix;
            } else {
                if ($model_seq->use_year) {
                    $prefix = $pre . substr(date("Y"), 2, 2);
                }
                if ($model_seq->use_month) {
                    $m = date('m');
                    // if($m < 10){$m="0".$m;}
                    $prefix = $prefix . $m;
                }
                if ($model_seq->use_day) {
                    $d = date('d');
                    ///  if($d < 10){$d="0".$d;}
                    $prefix = $prefix . $d;
                }
                $prefix = $prefix . '-';
                $seq_len = strlen($model_seq->maximum);
                for ($l = 1; $l <= $seq_len - 1; $l++) {
                    $prefix .= "0";
                }
                return $prefix . '1';
            }
        }
    }

}
