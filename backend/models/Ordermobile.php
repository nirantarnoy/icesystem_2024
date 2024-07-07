<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

date_default_timezone_set('Asia/Bangkok');


class Ordermobile extends \common\models\Orders
{
    /**
     * @var mixed|null
     */

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
//            'timestampcby' => [
//                'class' => \yii\behaviors\AttributeBehavior::className(),
//                'attributes' => [
//                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_by',
//                ],
//                'value' => Yii::$app->user->id,
//            ],
//            'timestamuby' => [
//                'class' => \yii\behaviors\AttributeBehavior::className(),
//                'attributes' => [
//                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
//                ],
//                'value' => Yii::$app->user->id,
//            ],
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
//            'timestampupdate' => [
//                'class' => \yii\behaviors\AttributeBehavior::className(),
//                'attributes' => [
//                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
//                ],
//                'value' => time(),
//            ],
        ];
    }

    public static function getLastNo($date, $company_id, $branch_id)
    {
        //   $model = Orders::find()->MAX('order_no');
        $model = Orders::find()->where(['date(order_date)' => date('Y-m-d', strtotime($date))])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])->MAX('order_no');

//        $model_seq = \backend\models\Sequence::find()->where(['module_id'=>4])->one();
//        //$pre = \backend\models\Sequence::find()->where(['module_id'=>15])->one();
//        $pre = '';
//        $prefix = '';
//        if($model_seq){
//            $pre =$model_seq->prefix;
//            if($model){
//                if($model_seq->use_year){
//                    $prefix = $pre.substr(date("Y"),2,2);
//                }
//                if($model_seq->use_month){
//                    $m = date('m');
//                    //if($m < 10){$m="0".$m;}
//                    $prefix = $prefix.$m;
//                }
//                if($model_seq->use_day){
//                    $d = date('d');
//                    //if($d < 10){$d="0".$d;}
//                    $prefix = $prefix.$d;
//                }
//
//                $seq_len = strlen($prefix);
//                $cnum = substr((string)$model,$seq_len,strlen($model));
//                $len = strlen($cnum);
//                $clen = strlen($cnum + 1);
//                $loop = $len - $clen;
//                for($i=1;$i<=$loop;$i++){
//                    $prefix.="0";
//                }
//                $prefix.=$cnum + 1;
//                return $prefix;
//            }else{
//                if($model_seq->use_year){
//                    $prefix = $pre.substr(date("Y"),2,2);
//                }
//                if($model_seq->use_month){
//                    $m = date('m');
//                   // if($m < 10){$m="0".$m;}
//                    $prefix = $prefix.$m;
//                }
//                if($model_seq->use_day){
//                    $d = date('d');
//                  ///  if($d < 10){$d="0".$d;}
//                    $prefix = $prefix.$d;
//                }
//                $seq_len = strlen($model_seq->maximum);
//                for($l=1;$l<=$seq_len-1;$l++){
//                    $prefix.="0";
//                }
//                return $prefix.'1';
//            }
//        }


        $pre = "SO";
        if ($model != null) {
//            $prefix = $pre.substr(date("Y"),2,2);
//            $cnum = substr((string)$model,4,strlen($model));
//            $len = strlen($cnum);
//            $clen = strlen($cnum + 1);
//            $loop = $len - $clen;
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

    public static function getLastNoMobile($company_id, $branch_id)
    {
        $date = date('Y-m-d');
        //   $model = Orders::find()->MAX('order_no');
  //      $model = Orders::find()->where(['date(order_date)' => date('Y-m-d', strtotime($date))])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id,'sale_from_mobile'=>1])->andFilterWhere(['like','order_no','CO'])->MAX('order_no');
        $model = Orders::find()->where(['date(order_date)' => date('Y-m-d')])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id,'sale_from_mobile'=>1])->andFilterWhere(['like','order_no','CO'])->MAX('order_no');

//        $model_seq = \backend\models\Sequence::find()->where(['module_id'=>4])->one();
//        //$pre = \backend\models\Sequence::find()->where(['module_id'=>15])->one();
//        $pre = '';
//        $prefix = '';
//        if($model_seq){
//            $pre =$model_seq->prefix;
//            if($model){
//                if($model_seq->use_year){
//                    $prefix = $pre.substr(date("Y"),2,2);
//                }
//                if($model_seq->use_month){
//                    $m = date('m');
//                    //if($m < 10){$m="0".$m;}
//                    $prefix = $prefix.$m;
//                }
//                if($model_seq->use_day){
//                    $d = date('d');
//                    //if($d < 10){$d="0".$d;}
//                    $prefix = $prefix.$d;
//                }
//
//                $seq_len = strlen($prefix);
//                $cnum = substr((string)$model,$seq_len,strlen($model));
//                $len = strlen($cnum);
//                $clen = strlen($cnum + 1);
//                $loop = $len - $clen;
//                for($i=1;$i<=$loop;$i++){
//                    $prefix.="0";
//                }
//                $prefix.=$cnum + 1;
//                return $prefix;
//            }else{
//                if($model_seq->use_year){
//                    $prefix = $pre.substr(date("Y"),2,2);
//                }
//                if($model_seq->use_month){
//                    $m = date('m');
//                   // if($m < 10){$m="0".$m;}
//                    $prefix = $prefix.$m;
//                }
//                if($model_seq->use_day){
//                    $d = date('d');
//                  ///  if($d < 10){$d="0".$d;}
//                    $prefix = $prefix.$d;
//                }
//                $seq_len = strlen($model_seq->maximum);
//                for($l=1;$l<=$seq_len-1;$l++){
//                    $prefix.="0";
//                }
//                return $prefix.'1';
//            }
//        }


        $pre = "CO";
        if ($model != null) {
//            $prefix = $pre.substr(date("Y"),2,2);
//            $cnum = substr((string)$model,4,strlen($model));
//            $len = strlen($cnum);
//            $clen = strlen($cnum + 1);
//            $loop = $len - $clen;
            $prefix = $pre . '-' . substr(date("Y"), 2, 2) . date('m', strtotime($date)) . date('d', strtotime($date)) . '-';
            $cnum = substr((string)$model, 10, 4);
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
    public static function getLastNoMobile2($company_id, $branch_id)
    {
        $date = date('Y-m-d');
        //   $model = Orders::find()->MAX('order_no');
        //      $model = Orders::find()->where(['date(order_date)' => date('Y-m-d', strtotime($date))])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id,'sale_from_mobile'=>1])->andFilterWhere(['like','order_no','CO'])->MAX('order_no');
        $model = Orders::find()->where(['date(order_date)' => date('Y-m-d')])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id,'sale_from_mobile'=>1])->andFilterWhere(['like','order_no','CO'])->MAX('order_no');

//        $model_seq = \backend\models\Sequence::find()->where(['module_id'=>4])->one();
//        //$pre = \backend\models\Sequence::find()->where(['module_id'=>15])->one();
//        $pre = '';
//        $prefix = '';
//        if($model_seq){
//            $pre =$model_seq->prefix;
//            if($model){
//                if($model_seq->use_year){
//                    $prefix = $pre.substr(date("Y"),2,2);
//                }
//                if($model_seq->use_month){
//                    $m = date('m');
//                    //if($m < 10){$m="0".$m;}
//                    $prefix = $prefix.$m;
//                }
//                if($model_seq->use_day){
//                    $d = date('d');
//                    //if($d < 10){$d="0".$d;}
//                    $prefix = $prefix.$d;
//                }
//
//                $seq_len = strlen($prefix);
//                $cnum = substr((string)$model,$seq_len,strlen($model));
//                $len = strlen($cnum);
//                $clen = strlen($cnum + 1);
//                $loop = $len - $clen;
//                for($i=1;$i<=$loop;$i++){
//                    $prefix.="0";
//                }
//                $prefix.=$cnum + 1;
//                return $prefix;
//            }else{
//                if($model_seq->use_year){
//                    $prefix = $pre.substr(date("Y"),2,2);
//                }
//                if($model_seq->use_month){
//                    $m = date('m');
//                   // if($m < 10){$m="0".$m;}
//                    $prefix = $prefix.$m;
//                }
//                if($model_seq->use_day){
//                    $d = date('d');
//                  ///  if($d < 10){$d="0".$d;}
//                    $prefix = $prefix.$d;
//                }
//                $seq_len = strlen($model_seq->maximum);
//                for($l=1;$l<=$seq_len-1;$l++){
//                    $prefix.="0";
//                }
//                return $prefix.'1';
//            }
//        }


        $pre = "CO";
        if ($model != null) {
//            $prefix = $pre.substr(date("Y"),2,2);
//            $cnum = substr((string)$model,4,strlen($model));
//            $len = strlen($cnum);
//            $clen = strlen($cnum + 1);
//            $loop = $len - $clen;
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
    //public static function getLastNoMobileNew($date, $company_id, $branch_id, $route_id,$route_code) // for go api
    public static function getLastNoMobileNew($date, $company_id, $branch_id, $route_id)
    {
        //   $model = Orders::find()->MAX('order_no');
        $model = Orders::find()->where(['date(order_date)' => date('Y-m-d', strtotime($date))])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id,'sale_from_mobile'=>1,'order_channel_id'=>$route_id])->andFilterWhere(['like','order_no','CO'])->MAX('order_no');
        $route_code = \backend\models\Deliveryroute::findRoutecode($route_id);
        $pre = "CO-".$route_code;
        //CO-VP01-211122-0001
        if ($model != null) {
//            $prefix = $pre.substr(date("Y"),2,2);
//            $cnum = substr((string)$model,4,strlen($model));
//            $len = strlen($cnum);
//            $clen = strlen($cnum + 1);
//            $loop = $len - $clen;
            $prefix = $pre . '-' . substr(date("Y"), 2, 2) . date('m', strtotime($date)) . date('d', strtotime($date)) . '-';
            $cnum = substr((string)$model, 15, 4);
           // $len = strlen($model_seq->maximum);
            $len = strlen($cnum);
            $clen = strlen($cnum + 1);
            $loop = $len - $clen;
           // $loop = 4;

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

    public static function findOrderemp($id)
    {
        $html = '';
        if ($id) {
//            $x_date = explode('/', $trans_date);
//            $t_date = date('Y-m-d');
//            if (count($x_date) > 1) {
//                $t_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
//            }

            $model_o = \backend\models\Orders::find()->where(['id' => $id])->one();
            if ($model_o) {
                $t_date = date('Y-m-d', strtotime($model_o->order_date));

                $model = \backend\models\Cardaily::find()->where(['car_id' => $model_o->car_ref_id, 'date(trans_date)' => $t_date])->all();
                $i = 0;
                foreach ($model as $value) {
                    $i += 1;
                    $emp_code = \backend\models\Employee::findCode($value->employee_id);
                    $emp_fullname = \backend\models\Employee::findFullName($value->employee_id);

                    $html .= $emp_fullname . ' , ';

                }
            }

        }

        return $html;
    }

    public static function findordercash($order_id)
    {
        $total = 0;
        $model = \backend\models\Orderline::find()->where(['order_id' => $order_id])->all();
        if ($model) {
            foreach ($model as $value) {
                $cus_pay_method = \backend\models\Customer::findPayMethod($value->customer_id);
                $paymethod_id = \backend\models\Paymentmethod::find()->where(['id' => $cus_pay_method])->one();
                if ($paymethod_id) {
                    if ($paymethod_id->pay_type == 1) {
                        $total = $total + ($value->qty * $value->price);
                    }
                }
//                $paymethod_name = \backend\models\Paymentmethod::findName($cus_pay_method);
//                if($paymethod_name == 'เงินสด'){
//                    $total = $total + ($value->qty * $value->price);
//                }
            }

        }
        return $total;
    }

    public static function findordercredit($order_id)
    {
        $total = 0;
        $model = \backend\models\Orderline::find()->where(['order_id' => $order_id])->all();
        if ($model) {
            foreach ($model as $value) {
                $cus_pay_method = \backend\models\Customer::findPayMethod($value->customer_id);
//                $paymethod_name = \backend\models\Paymentmethod::findName($cus_pay_method);
//                if($paymethod_name == 'เงินเชื่อ' || $paymethod_name == 'เครดิต'){
//                    $total = $total + ($value->qty * $value->price);
//                }
                $paymethod_id = \backend\models\Paymentmethod::find()->where(['id' => $cus_pay_method])->one();
                if ($paymethod_id) {
                    if ($paymethod_id->pay_type == 2) {
                        $total = $total + ($value->qty * $value->price);
                    }
                }
            }

        }
        return $total;
    }

    public static function getNumber($id)
    {
        $model = Orders::find()->where(['id' => $id])->one();
        return $model != null ? $model->order_no : '';
    }

    public static function getOrderdate($id)
    {
        $model = Orders::find()->where(['id' => $id])->one();
        return $model != null ? $model->order_date : null;
    }
//    public function findUnitid($code){
//        $model = Unit::find()->where(['name'=>$code])->one();
//        return count($model)>0?$model->id:0;
//    }

}
