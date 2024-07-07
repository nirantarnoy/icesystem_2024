<?php

namespace backend\controllers;

use backend\models\OrderfinishedSearch;
use backend\models\OrderfinishedsumSearch;
use backend\models\Orderline;
use backend\models\WarehouseSearch;
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


class CloseorderController extends Controller
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

    public function actionIndex()
    {

        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new OrderfinishedsumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['>','qty',0]);
        $dataProvider->query->limit(100);
        $dataProvider->setSort(['defaultOrder' => ['order_date' => SORT_DESC, 'order_no' => SORT_DESC]]);
        $dataProvider->pagination->defaultPageSize = 50;
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    public function actionView($id)
    {
        $model = \common\models\QuerySaleFinishedSummary::find()->where(['id' => $id])->one();
        $modelline = \common\models\QuerySaleFinished::find()->where(['id' => $id])->all();
        return $this->render('view', [
            'model' => $model,
            'modelline' => $modelline,
        ]);
    }

    public function actionSubmitorderclose()
    {
        $order_id = \Yii::$app->request->post('order_id');
        $product_id = \Yii::$app->request->post('line_product_id');
        $qty = \Yii::$app->request->post('line_avl_qty');
        $warehouse_id = \Yii::$app->request->post('line_warehouse_id');

        if ($order_id && $product_id != null) {
            $res = 0;
            for ($i = 0; $i <= count($product_id) - 1; $i++) {
                if($qty[$i] <= 0)continue;
                $model = new \backend\models\Stocktrans();
                $model->journal_no = '';
                $model->trans_date = date('Y-m-d H:i:s');
                $model->product_id = $product_id[$i];
                $model->qty = $qty[$i];
                $model->warehouse_id = $warehouse_id[$i];
                $model->stock_type = 1;
                $model->activity_type_id = 7; // 1 prod rec 2 issue car
                if ($model->save()) {
                    $this->updateSummary($product_id[$i], $warehouse_id[$i], $qty[$i]);
                    $res += 1;
                }
            }
            if($res){
                $this->updateOrderStatus($order_id);
            }
        }
        return $this->redirect(['closeorder/index']);
    }

    public function updateSummary($product_id, $wh_id, $qty)
    {
        if ($wh_id != null && $product_id != null && $qty > 0) {
            $model = \backend\models\Stocksum::find()->where(['warehouse_id' => $wh_id, 'product_id' => $product_id])->one();
            if ($model) {
                $model->qty = ($model->qty + (int)$qty);
                $model->save(false);
            } else {
                $model_new = new \backend\models\Stocksum();
                $model_new->warehouse_id = $wh_id;
                $model_new->product_id = $product_id;
                $model_new->qty = $qty;
                $model_new->save(false);
            }
        }
    }

    public function updateOrderStatus($order_id)
    {
        if ($order_id) {
            $model = \backend\models\Orders::find()->where(['id' => $order_id])->one();
            if ($model) {
                $model->status = 100;
                $model->save();
            }
        }
    }

}
