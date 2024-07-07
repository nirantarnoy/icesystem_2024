<?php
namespace backend\controllers;

use backend\models\Journalissue;
use backend\models\JournalissueSearch;
use backend\models\Orderline;
use backend\models\Orders;
use backend\models\OrdersposSearch;
use backend\models\WarehouseSearch;
use common\models\LoginLog;
use Yii;
use backend\models\Car;
use backend\models\CarSearch;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\web\Session;

/**
 * CarController implements the CRUD actions for Car model.
 */
class DailysumController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST', 'GET'],
                ],
            ],
//            'access'=>[
//                'class'=>AccessControl::className(),
//                'denyCallback' => function ($rule, $action) {
//                    throw new ForbiddenHttpException('คุณไม่ได้รับอนุญาติให้เข้าใช้งาน!');
//                },
//                'rules'=>[
//                    [
//                        'allow'=>true,
//                        'roles'=>['@'],
//                        'matchCallback'=>function($rule,$action){
//                            $currentRoute = Yii::$app->controller->getRoute();
//                            if(Yii::$app->user->can($currentRoute)){
//                                return true;
//                            }
//                        }
//                    ]
//                ]
//            ],
        ];
    }
    public function actionIndex()
    {
        // $x = '2021-03-03';
        // $t_date = date('Y-m-d',strtotime($x));

//        $order_date = \Yii::$app->request->post('pos_date');
//        $route_id = \Yii::$app->request->post('route_id');
//
        $t_date = date('Y-m-d');
        $route_id = null;
        $user_id = null;
//
//        $x_date = explode('/', $order_date);
//        if (count($x_date) > 1) {
//            $t_date = $x_date[2] . '-' . $x_date[1] . '-' . $x_date[0];
//        }

        $searchModel = new \backend\models\SalemobiledatanewSearch();

        if(!empty(\Yii::$app->request->queryParams['SalemobiledatanewSearch'])) {
            $order_date = \Yii::$app->request->queryParams['SalemobiledatanewSearch']['post_date'];
            $route_id = \Yii::$app->request->queryParams['SalemobiledatanewSearch']['route_id'];
           // $user_id = \Yii::$app->request->queryParams['SalemobiledatanewSearch']['employee'];

            $t_date = date('Y-m-d');

            $x_date = explode('/', $order_date);
            if (count($x_date) > 1) {
                $t_date = $x_date[2] . '-' . $x_date[1] . '-' . $x_date[0];
            }
        }

       // print_r(Yii::$app->request->queryParams['SalemobiledatanewSearch']['post_date']); return;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->select(['product_id','code', 'name', 'price', 'SUM(qty) as qty',
            'SUM(line_total) as line_total','SUM(line_total_cash) as line_total_cash,SUM(line_total_credit) as line_total_credit',
            'SUM(line_qty_cash) as line_qty_cash','SUM(line_qty_credit) as line_qty_credit']);
        $dataProvider->pagination->pageSize = 100;
        $dataProvider->query->andFilterWhere(['>', 'qty', 0]);
        $dataProvider->query->andFilterWhere(['=', 'date(order_date)', $t_date]);
        if($route_id != null){
            $dataProvider->query->andFilterWhere(['=', 'route_id', $route_id]);
        }



        // $dataProvider->query->andFilterWhere(['=', 'order_no', 'SO-210721-0057']);

        $dataProvider->query->groupBy(['product_id','code', 'name', 'price']);
        $dataProvider->setSort([
            'defaultOrder' => ['item_pos_seq' => SORT_ASC]
        ]);

        $searchModel2 = new \backend\models\SalepospaySearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
        $dataProvider2->query->select(['code', 'name', 'SUM(payment_amount) as payment_amount']);
        $dataProvider2->query->andFilterWhere(['>', 'payment_amount', 0]);
        $dataProvider2->query->andFilterWhere(['date(order_date)' => $t_date]);
        $dataProvider2->query->groupBy(['code', 'name', 'sale_channel_id']);
        $dataProvider2->setSort([
            'defaultOrder' => ['code' => SORT_ASC]
        ]);
//        $searchModel2 = new \backend\models\SalepospaySearch();
//        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
//        $dataProvider2->query->select(['code', 'name', 'SUM(payment_amount) as payment_amount']);
//        $dataProvider2->query->andFilterWhere(['>', 'payment_amount', 0]);
//        $dataProvider2->query->andFilterWhere(['date(payment_date)' => $t_date]);
//        $dataProvider2->query->groupBy(['code', 'name']);
//        $dataProvider2->setSort([
//            'defaultOrder' => ['code' => SORT_ASC]
//        ]);

        return $this->render('_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
            'show_pos_date' => $t_date,
            'selected_route_id' => $route_id,
        ]);
    }

    public function actionIndexnew()
    {

        $t_date = date('Y-m-d');
        $route_id = null;
        $user_id = null;
//
//        $x_date = explode('/', $order_date);
//        if (count($x_date) > 1) {
//            $t_date = $x_date[2] . '-' . $x_date[1] . '-' . $x_date[0];
//        }

        $searchModel = new \backend\models\SalemobiledatanewSearch();

        if(!empty(\Yii::$app->request->queryParams['SalemobiledatanewSearch'])) {
            $order_date = \Yii::$app->request->queryParams['SalemobiledatanewSearch']['post_date'];
            $route_id = \Yii::$app->request->queryParams['SalemobiledatanewSearch']['route_id'];
            if(!empty(\Yii::$app->request->queryParams['SalemobiledatanewSearch']['employee_id'])){
                $user_id = \Yii::$app->request->queryParams['SalemobiledatanewSearch']['employee_id'];
            }


            $t_date = date('Y-m-d');

            $x_date = explode('/', $order_date);
            if (count($x_date) > 1) {
                $t_date = $x_date[2] . '-' . $x_date[1] . '-' . $x_date[0];
            }
        }
        $isnew = \Yii::$app->request->get('isnew');
        //echo $isnew;return;

        // print_r(Yii::$app->request->queryParams['SalemobiledatanewSearch']['post_date']); return;

        if($route_id != null){
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->select(['product_id','code', 'name', 'price', 'SUM(qty) as qty',
                'SUM(line_total) as line_total','SUM(line_total_cash) as line_total_cash,SUM(line_total_credit) as line_total_credit',
                'SUM(line_qty_cash) as line_qty_cash','SUM(line_qty_credit) as line_qty_credit','SUM(line_qty_free) as line_qty_free']);
            $dataProvider->pagination->pageSize = 100;
            $dataProvider->query->andFilterWhere(['>', 'qty', 0]);
            $dataProvider->query->andFilterWhere(['=', 'date(order_date)', $t_date]);
            if($route_id != null){
                $dataProvider->query->andFilterWhere(['=', 'route_id', $route_id]);
            }
            if($user_id != null || $user_id != ''){
                $dataProvider->query->andFilterWhere(['=', 'created_by', $user_id]);
            }
        }else{
           // echo "ok";return;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->select(['product_id','code', 'name', 'price', 'SUM(qty) as qty',
                'SUM(line_total) as line_total','SUM(line_total_cash) as line_total_cash,SUM(line_total_credit) as line_total_credit',
                'SUM(line_qty_cash) as line_qty_cash','SUM(line_qty_credit) as line_qty_credit','SUM(line_qty_free) as line_qty_free']);
            $dataProvider->pagination->pageSize = 100;
//            $dataProvider->query->andFilterWhere(['=', 'route_id', 0]);
            $dataProvider->query->andFilterWhere(['>', 'qty', 0]);
            $dataProvider->query->andFilterWhere(['=', 'date(order_date)', $t_date]);

        }





        // $dataProvider->query->andFilterWhere(['=', 'order_no', 'SO-210721-0057']);

        $dataProvider->query->groupBy(['product_id','code', 'name', 'price']);
        $dataProvider->setSort([
            'defaultOrder' => ['item_pos_seq' => SORT_ASC]
        ]);

//        $searchModel2 = new \backend\models\SalepospaySearch();
//        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
//        $dataProvider2->query->select(['code', 'name', 'SUM(payment_amount) as payment_amount']);
//        $dataProvider2->query->andFilterWhere(['>', 'payment_amount', 0]);
//        $dataProvider2->query->andFilterWhere(['date(order_date)' => $t_date]);
//        $dataProvider2->query->groupBy(['code', 'name', 'sale_channel_id']);
//        $dataProvider2->setSort([
//            'defaultOrder' => ['code' => SORT_ASC]
//        ]);

        return $this->render('_indexnew', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
//            'searchModel2' => $searchModel2,
//            'dataProvider2' => $dataProvider2,
            'show_pos_date' => $t_date,
            'selected_route_id' => $route_id,
            'user_id'=>$user_id,
            'isnew'=>$isnew,
        ]);
    }
    public function actionFindshiftemp(){
        $trans_date = \Yii::$app->request->post('trans_date');
        $id = \Yii::$app->request->post('id');
        $html = '';
        if($trans_date != '' && $id != null){
            $t_date = date('Y-m-d');

            $x_date = explode('/', $trans_date);
            if (count($x_date) > 1) {
                $t_date = $x_date[2] . '-' . $x_date[1] . '-' . $x_date[0];
            }
          //  $model = \common\models\SaleRouteDailyClose::find()->where(['route_id'=>$id])->groupBy('crated_by')->all();
            $model = \common\models\SaleRouteDailyClose::find()->where(['route_id'=>$id,'date(trans_date)'=>$t_date])->groupBy('crated_by')->all();
            if($model){
               foreach($model as $value){
                   $emp_id = \backend\models\User::findEmpId($value->crated_by);
                   $html.='<option value="'.$value->crated_by.'">';
                   $html.= \backend\models\Employee::findFullName($emp_id);
                   $html.='</option>';
               }

           }
        }
        echo $html;
    }
}
