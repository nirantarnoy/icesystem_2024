<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

date_default_timezone_set('Asia/Bangkok');

class Branchtransfer extends \common\models\BranchTransfer
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
//    public function findName($id){
//        $model = Unit::find()->where(['id'=>$id])->one();
//        return count($model)>0?$model->name:'';
//    }
//    public function findUnitid($code){
//        $model = Unit::find()->where(['name'=>$code])->one();
//        return count($model)>0?$model->id:0;
//    }


//    public static function getLastNo()
//    {
//        $model = \common\models\BranchTransfer::find()->MAX('journal_no');
//        //   $model = Orders::find()->where(['date(order_date)' => date('Y-m-d', strtotime($date))])->MAX('order_no');
//
//        $model_seq = \backend\models\Sequence::find()->where(['module_id' => \backend\helpers\RunnoTitle::RUNNO_TRANSFER])->one();
//        //$pre = \backend\models\Sequence::find()->where(['module_id'=>15])->one();
//        $pre = '';
//        $prefix = '';
//        if ($model_seq) {
//            $pre = $model_seq->prefix;
//            if ($model) {
//                if ($model_seq->use_year) {
//                    $prefix = $pre . substr(date("Y"), 2, 2);
//                }
//                if ($model_seq->use_month) {
//                    $m = date('m');
//                    //if($m < 10){$m="0".$m;}
//                    $prefix = $prefix . $m;
//                }
//                if ($model_seq->use_day) {
//                    $d = date('d');
//                    //if($d < 10){$d="0".$d;}
//                    $prefix = $prefix . $d;
//                }
//
//                $seq_len = strlen($prefix);
//                $cnum = substr((string)$model, $seq_len, strlen($model));
//                $len = strlen($cnum);
//                $clen = strlen($cnum + 1);
//                $loop = $len - $clen;
//                for ($i = 1; $i <= $loop; $i++) {
//                    $prefix .= "0";
//                }
//                $prefix .= $cnum + 1;
//                return $prefix;
//            } else {
//                if ($model_seq->use_year) {
//                    $prefix = $pre . substr(date("Y"), 2, 2);
//                }
//                if ($model_seq->use_month) {
//                    $m = date('m');
//                    // if($m < 10){$m="0".$m;}
//                    $prefix = $prefix . $m;
//                }
//                if ($model_seq->use_day) {
//                    $d = date('d');
//                    ///  if($d < 10){$d="0".$d;}
//                    $prefix = $prefix . $d;
//                }
//                $seq_len = strlen($model_seq->maximum);
//                for ($l = 1; $l <= $seq_len - 1; $l++) {
//                    $prefix .= "0";
//                }
//                return $prefix . '1';
//            }
//        }
//    }

    public static function getLastNo($company_id, $branch_id)
    {
        $model = Stocktrans::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->MAX('journal_no');
        //   $model = Orders::find()->where(['date(order_date)' => date('Y-m-d', strtotime($date))])->MAX('order_no');

        $model_seq = \backend\models\Sequence::find()->where(['module_id' => 19, 'company_id' => $company_id, 'branch_id' => $branch_id])->one();
        //$pre = \backend\models\Sequence::find()->where(['module_id'=>15])->one();
        $pre = '';
        $prefix = '';
        if ($model_seq) {
            $pre = $model_seq->prefix;
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

                $seq_len = strlen($prefix);
                $cnum = substr((string)$model, $seq_len, strlen($model));
                $len = strlen($cnum);
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
                $seq_len = strlen($model_seq->maximum);
                for ($l = 1; $l <= $seq_len - 1; $l++) {
                    $prefix .= "0";
                }
                return $prefix . '1';
            }
        }
    }

}
