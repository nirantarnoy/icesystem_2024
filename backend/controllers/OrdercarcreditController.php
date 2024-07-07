<?php

namespace backend\controllers;

use backend\models\Cardaily;
use backend\models\Employee;
use backend\models\Orderline;

//use backend\models\WarehouseSearch;
use backend\models\Pricegroup;
use common\models\OrderLineTrans;
use common\models\PriceCustomerType;
use Yii;
use backend\models\Orders;
use backend\models\OrdersSearch;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\date\DatePicker;
use kartik\time\TimePicker;


class OrdercarcreditController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionPrintcarsummary()
    {
        $company_id = 0;
        $branch_id = 0;

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }

        $from_date = \Yii::$app->request->post('from_date');
        $to_date = \Yii::$app->request->post('to_date');
        //  $find_sale_type = \Yii::$app->request->post('find_sale_type');
        $find_user_id = \Yii::$app->request->post('find_user_id');
        $sale_type = \Yii::$app->request->post('sale_type');
        return $this->render('_print_sale_car_summary', [
            'from_date' => $from_date,
            'to_date' => $to_date,
            //    'find_sale_type'=>$find_sale_type,
            'find_user_id' => $find_user_id,
            'company_id' => $company_id,
            'branch_id' => $branch_id,
            'sale_type' => $sale_type,
        ]);
    }

    public function actionCarsummaryupdate()
    {
        $company_id = 0;
        $branch_id = 0;

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }

        $from_date = \Yii::$app->request->post('from_date');
        $to_date = \Yii::$app->request->post('to_date');
        //  $find_sale_type = \Yii::$app->request->post('find_sale_type');
        $find_user_id = \Yii::$app->request->post('find_user_id');
        $sale_type = \Yii::$app->request->post('sale_type');
        return $this->render('_sale_car_update', [
            'from_date' => $from_date,
            'to_date' => $to_date,
            //    'find_sale_type'=>$find_sale_type,
            'find_user_id' => $find_user_id,
            'company_id' => $company_id,
            'branch_id' => $branch_id,
            'sale_type' => $sale_type,
        ]);
    }

    public function actionSaveupdate()
    {
        $company_id = 0;
        $branch_id = 0;

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }
        $order_id = \Yii::$app->request->post('order_id');
        $delivery_no = \Yii::$app->request->post('delivery_no');
        if ($order_id != null) {
            for ($i = 0; $i <= count($order_id) - 1; $i++) {
                $model = \backend\models\Orders::find()->where(['id' => $order_id[$i]])->one();
                if($model){
                    $model->customer_ref_no = $delivery_no[$i];
                    $model->save();
                }
            }
        }
        return $this->redirect(['ordercarcredit/carsummaryupdate']);
    }
}
