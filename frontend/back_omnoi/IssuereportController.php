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
class IssuereportController extends Controller
{
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
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new ForbiddenHttpException('คุณไม่ได้รับอนุญาติให้เข้าใช้งาน!');
                },
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $currentRoute = \Yii::$app->controller->getRoute();
                            if (\Yii::$app->user->can($currentRoute)) {
                                return true;
                            }
                        }
                    ]
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        // $limit = \Yii::$app->request->queryParams['_toga654c069'];
         $limit = '';
        // print_r(\Yii::$app->request->queryParams);return;
       // echo "limit is ".\Yii::$app->request->post('limit');
        $searchModel = new IssuereportSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        //    $dataProvider_footer = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->query->andFilterWhere(['activity_type_id'=>15]);
        if($limit != 'all'){
            $dataProvider->pagination->pageSize = 800;
        }else{
            $dataProvider->pagination->pageSize = 1000;
        }

        $dataProvider->query->andFilterWhere(['>', 'qty', 0]);
        // $dataProvider->query->andFilterWhere(['is not', 'product_id', new \yii\db\Expression('null')]);
        $dataProvider->setSort(['defaultOrder' => ['delivery_route_id' => SORT_ASC, 'order_no' => SORT_ASC, 'product_id' => SORT_ASC, 'temp_update' => SORT_ASC]]);

        $model_bottom = $dataProvider->getModels();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model_bottom' => $model_bottom,
            // 'dataProvider_footer'=>$dataProvider_footer,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = Stocksum::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
