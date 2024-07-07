<?php

namespace frontend\modules\api\controllers;

use common\models\Plan;
use yii\filters\VerbFilter;
use yii\web\Controller;

date_default_timezone_set('Asia/Bangkok');

class PlanController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'addplan' => ['POST'],
                    'listplan' => ['POST'],
                    'listplanbycustomer' => ['POST'],
                    'deleteplanline' => ['POST'],
                    'deleteplan' => ['POST'],
                    'updateplan' => ['POST'],

                ],
            ],
        ];
    }

    public function actionAddplan()
    {
        $customer_id = null;
        $status = false;
        $user_id = 0;
        $route_id = 0;
        $car_id = 0;
        $company_id = 0;
        $branch_id = 0;
        $datalist = null;
        $plan_date = null;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        if ($req_data != null) {
            $plan_date = $req_data['plan_date'];
            $customer_id = $req_data['customer_id'];
            $user_id = $req_data['user_id'] == null ? 0 : $req_data['user_id'];
            $route_id = $req_data['route_id'];
            $car_id = $req_data['car_id'];
            $company_id = $req_data['company_id'];
            $branch_id = $req_data['branch_id'];
            $datalist = $req_data['data'];
        }

        $data = [];

        if ($route_id && $car_id && $company_id && $branch_id) {
            //  $sale_date = date('Y/m/d');
            $sale_date = date('Y/m/d');

            $sale_time = date('H:i:s');
            $order_total_all = 0;
            $has_order = $this->hasPlan($sale_date, $route_id, $car_id);
            if ($has_order != null) {
                $has_order_id = $has_order->id;
                if ($has_order_id) {
                    if (count($datalist) > 0) {
                        for ($i = 0; $i <= count($datalist) - 1; $i++) {
                            if ($datalist[$i]['qty'] <= 0) continue;

                            // $price_group_id = $this->findCustomerpricgroup($customer_id, $datalist[$i]['product_id'], $route_id);

                            $model_line_trans = new \backend\models\Planline();
                            $model_line_trans->plan_id = $has_order_id;
                            $model_line_trans->product_id = $datalist[$i]['product_id'];
                            $model_line_trans->qty = $datalist[$i]['qty'];
                            $model_line_trans->status = 1;
                            if ($model_line_trans->save(false)) {
                            }


                        }
                    }
                }
            } else {
                $model = new \backend\models\Plan();
                $model->journal_no = $model->getLastNo($sale_date, $company_id, $branch_id);
                // $model->order_date = date('Y-m-d H:i:s', strtotime($sale_date . ' ' . $sale_time));
                $model->trans_date = date('Y-m-d H:i:s');
                $model->customer_id = $customer_id;
                $model->route_id = $route_id;
                $model->car_id = $car_id;
                $model->status = 1;
                $model->created_by = $user_id;
                $model->company_id = $company_id;
                $model->branch_id = $branch_id;
                if ($model->save(false)) {
                    // array_push($data, ['order_id' => $model->id]);
                    if (count($datalist) > 0) {
                        for ($i = 0; $i <= count($datalist) - 1; $i++) {
                            if ($datalist[$i]['qty'] <= 0) continue;

                            // $price_group_id = $this->findCustomerpricgroup($customer_id, $datalist[$i]['product_id'], $route_id);

                            $model_line_trans = new \backend\models\Planline();
                            $model_line_trans->plan_id = $model->id;
                            $model_line_trans->product_id = $datalist[$i]['product_id'];
                            $model_line_trans->qty = $datalist[$i]['qty'];
                            $model_line_trans->status = 1;
                            if ($model_line_trans->save(false)) {

                                // end issue order stock
                            }
                        }
                    }
                    $this->createIssue($model->id, $datalist, $company_id, $branch_id, $user_id, $route_id);
                }
            }
        }
        //  array_push($data,['data'=>$req_data]);

        return ['status' => $status, 'data' => $data];
    }

    public function createIssue($plan_id, $datalist, $company_id, $branch_id, $user_id, $route_id){
        $res = 0;
        if (count($datalist) > 0 && $plan_id) {
            $sale_date = date('Y-m-d', strtotime("+1 day"));
            $c_time = date('H:i:s');

            $model = new \backend\models\Journalissue();
            $model->journal_no = $model->getLastNo($sale_date, $company_id, $branch_id);
            $model->trans_date = date('Y-m-d H:i:s', strtotime($sale_date.' '.$c_time));
            $model->status = 1;
            $model->reason_id = 1;
            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            $model->created_by = $user_id;
            $model->delivery_route_id = $route_id;
            $model->plan_id = $plan_id;
            if ($model->save(false)) {
                if (count($datalist) > 0) {
                    for ($i = 0; $i <= count($datalist) - 1; $i++) {
                        if ($datalist[$i]['qty'] <= 0) continue;
                        $model_line = new \backend\models\Journalissueline();
                        $model_line->issue_id = $model->id;
                        $model_line->product_id = $datalist[$i]['product_id'];
                        $model_line->qty = $datalist[$i]['qty'];
                        $model_line->avl_qty = $datalist[$i]['qty'];
                        $model_line->sale_price = 0;
                        $model_line->status = 1;
                        if ($model_line->save()) {
                            $res +=1;

                        }
                    }
                }
            }

        }
        return $res;
    }

    public function hasPlan($order_date, $route_id, $car_id)
    {
        $order_date = date('Y-m-d');
        $res = null;
        if ($route_id && $car_id) {
            $model = \common\models\Plan::find()->where(['date(trans_date)' => $order_date, 'route_id' => $route_id, 'car_id' => $car_id, 'status' => 1])->one();
            $res = $model;
        }
        return $res;
    }

    public function actionListplan()
    {
        $status = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $car_id = $req_data['car_id'];
        $api_date = $req_data['plan_date'];

        $data = [];
        if ($car_id) {

            $sale_date = date('Y-m-d');
            $t_date = null;
            $exp_order_date = explode(' ', $api_date);
            if ($exp_order_date != null) {
                if (count($exp_order_date) > 1) {
                    $x_date = explode('-', $exp_order_date[0]);
                    if (count($x_date) > 1) {
                        $t_date = $x_date[0] . "/" . $x_date[1] . "/" . $x_date[2];
                    }
                }
            }
            if ($t_date != null) {
                $sale_date = $t_date;
            }

            $model = \common\models\Plan::find()->where(['car_id' => $car_id, 'date(trans_date)' => $sale_date])->all();
            // $model = \common\models\Orders::find()->where(['id'=>131])->all();
            //  $model = \common\models\Orders::find()->where(['car_ref_id' => $car_id])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'id' => $value->id,
                        'tran_no' => $value->journal_no,
                        'trans_date' => $value->trans_date,
                        'route_id' => $value->route_id,
                        'route_name' => '',
                        'customer_id' => $value->customer_id,
                        'customer_name' => \backend\models\Customer::findName($value->customer_id),
                        'status' => $value->status,
                    ]);
                }
            }
        }
        return ['status' => $status, 'data' => $data];
    }


    public function actionListplanbycustomer()
    {
        $status = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $customer_id = $req_data['customer_id'];
        $plan_id = $req_data['plan_id'];

        $data = [];
        if ($customer_id) {
            //$model = \common\models\QueryApiOrderDaily::find()->where(['customer_id' => $customer_id])->andFilterWhere(['id' => $order_id])->andFilterWhere(['>', 'qty', 0])->all();
            //$model = \backend\models\Plan::find()->where([])->one();
            $model_line = \common\models\PlanLine::find()->where(['plan_id' => $plan_id])->all();
            if ($model_line) {
                $status = true;
                foreach ($model_line as $value) {
                    array_push($data, [
                        'id' => $value->id,
                        'product_id' => $value->product_id,
                        'product_name' => \backend\models\Product::findName($value->product_id),
                        'qty' => $value->qty,
                        'status' => $value->status,
                    ]);
                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }


    public function actionDeleteplanline()
    {
        $status = false;
        $id = null;


        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $id = $req_data['id'];

        $data = [];
        if ($id) {
            if (\backend\models\Planline::deleteAll(['id' => $id])) {
                $status = true;
            }
        }

        return ['status' => $status, 'data' => $data];
    }

    public function actionDeleteplan()
    {
        $status = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $plan_id = $req_data['plan_id'];
      //  $customer_id = $req_data['customer_id'];

        $data = [];
        if ($plan_id != null) {
            if (\backend\models\Planline::deleteAll(['plan_id' => $plan_id])) {
                if(Plan::deleteAll(['id' => $plan_id])){
                    $issue_id = \backend\models\Journalissue::find()->where(['plan_id'=> $plan_id])->one();
                    if($issue_id){
                        \backend\models\Journalissueline::deleteAll(['issue_id'=>$issue_id->id]);
                        \backend\models\Journalissue::deleteAll(['plan_id'=> $plan_id]);
                    }
                }
                $status = true;
            }else{
                if(Plan::deleteAll(['id' => $plan_id])){
                    $issue_id = \backend\models\Journalissue::find()->where(['plan_id'=> $plan_id])->one();
                    if($issue_id){
                        \backend\models\Journalissueline::deleteAll(['issue_id'=>$issue_id->id]);
                        \backend\models\Journalissue::deleteAll(['plan_id'=> $plan_id]);
                    }

                }

                $status = true;
            }

//            if (\common\models\Planline::updateAll(['qty' => 0, 'price' => 0, 'line_total' => 0], ['order_id' => $order_id, 'customer_id' => $customer_id])) {
//                $status = true;
//            }
        }
        return ['status' => $status, 'data' => $data];
    }


}
