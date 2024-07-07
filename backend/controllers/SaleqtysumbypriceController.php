<?php

namespace backend\controllers;

use backend\models\IssuereportSearch;
use backend\models\ProdrecSearch;
use Yii;
use backend\models\Stocksum;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StocksumController implements the CRUD actions for Stocksum model.
 */
class SaleqtysumbypriceController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
//            'access' => [
//                'class' => AccessControl::className(),
//                'denyCallback' => function ($rule, $action) {
//                    throw new ForbiddenHttpException('คุณไม่ได้รับอนุญาติให้เข้าใช้งาน!');
//                },
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['@'],
//                        'matchCallback' => function ($rule, $action) {
//                            $currentRoute = Yii::$app->controller->getRoute();
//                            if (Yii::$app->user->can($currentRoute)) {
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
        $from_date = \Yii::$app->request->post('from_date');
        $to_date = \Yii::$app->request->post('to_date');
        $find_sale_type = \Yii::$app->request->post('find_sale_type');
        $is_invoice_req = \Yii::$app->request->post('is_invoice_req');
        $btn_order_type = \Yii::$app->request->post('btn_order_type');
        return $this->render('index', [
            'from_date' => $from_date,
            'to_date'=> $to_date,
            'find_sale_type' => $find_sale_type,
            'is_invoice_req' => $is_invoice_req,
            'btn_order_type' => $btn_order_type
        ]);
    }
    public function actionIndex2()
    {
        $from_date = \Yii::$app->request->post('from_date');
        $to_date = \Yii::$app->request->post('to_date');
        $find_sale_type = \Yii::$app->request->post('find_sale_type');
        $is_invoice_req = \Yii::$app->request->post('is_invoice_req');
        $btn_order_type = \Yii::$app->request->post('btn_order_type');
        return $this->render('_index', [
            'from_date' => $from_date,
            'to_date'=> $to_date,
            'find_sale_type' => $find_sale_type,
            'is_invoice_req' => $is_invoice_req,
            'btn_order_type' => $btn_order_type
        ]);
    }


}
