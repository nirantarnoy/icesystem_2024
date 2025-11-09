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
class CustomerroutenumupdateController extends Controller
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
       $route_id = \Yii::$app->request->post('route_id');
       $model = null;
       if($route_id!=null){
           $model = \backend\models\Customer::find()->where(['delivery_route_id'=>$route_id,'status'=>1])->orderBy(['route_num'=>SORT_ASC])->all();
       }

       return $this->render('_formupdate',[
           'route_id'=>$route_id,
           'model'=>$model,
       ]);
    }

    public function actionUpdate(){
        $customer_id = \Yii::$app->request->post('customer_id');
        $route_num = \Yii::$app->request->post('route_num');
        if($customer_id!=null){
            for($i=0;$i<=count($customer_id)-1;$i++){
                if($route_num[$i] == null)continue;
                $model = \backend\models\Customer::find()->where(['id'=>$customer_id[$i]])->one();
                if($model){
                    $model->route_num = $route_num[$i];
                    $model->save(false);
                }
            }
        }
        \Yii::$app->session->setFlash('success', 'อัปเดตข้อมูลเรียบร้อย');
        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = Stocksum::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
