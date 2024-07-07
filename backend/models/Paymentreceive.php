<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

date_default_timezone_set('Asia/Bangkok');

class Paymentreceive extends \common\models\PaymentReceive
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

    public static function getLastNo($date)
    {
        //   $model = Orders::find()->MAX('order_no');
        $model = Paymentreceive::find()->where(['date(trans_date)' => date('Y-m-d', strtotime($date))])->MAX('journal_no');
        $pre = "AR";
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

    public static function getLastNo2($date, $company_id, $branch_id)
    {
        //   $model = Orders::find()->MAX('order_no');
       // $model = Paymentreceive::find()->where(['date(trans_date)' => date('Y-m-d', strtotime($date))])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])->MAX('journal_no');
        $model = Paymentreceive::find()->where(['date(trans_date)' => date('Y-m-d', strtotime($date))])->MAX('journal_no');
       // $model = Paymentreceive::find()->select(['journal_no'])->where(['date(trans_date)' => date('Y-m-d', strtotime($date))])->orderBy(['id'=>SORT_DESC])->one();
        $pre = "AR";
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

    public static function findPayamt($id)
    {
        $model = \common\models\PaymentReceiveLine::find()->where(['payment_receive_id' => $id])->sum('payment_amount');
        return $model != null ? $model : 0;
    }

    public static function findPayorderamt($order_id)
    {
        $total = 0;
     //   $model = \common\models\PaymentReceiveLine::find()->where(['order_id' => $order_id])->sum('payment_amount');
        $model = \common\models\PaymentReceiveLine::find()->select('payment_amount')->where(['order_id' => $order_id])->all();
        if($model){
            foreach($model as $value){
                $total = $total + $value->payment_amount;
            }
        }
        return $total;
    }


//    public function findName($id){
//        $model = Position::find()->where(['id'=>$id])->one();
//        return $model!= null?$model->name:'';
//    }
    public static function findNo($id){
        $model = Paymentreceive::find()->where(['id'=>$id])->one();
        return $model!=null?$model->journal_no:'';
    }
    public static function findDate($id){
        $model = Paymentreceive::find()->where(['id'=>$id])->one();
        return $model!=null?$model->trans_date:'';
    }
    public static function findEmpId($id){
        $model = Paymentreceive::find()->where(['id'=>$id])->one();
        return $model!=null?$model->crated_by:0;
    }

}
