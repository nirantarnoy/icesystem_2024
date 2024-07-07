<?php

namespace backend\controllers;


use backend\models\ScrapSearch;
use Yii;
use backend\models\Stocksum;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StocksumController implements the CRUD actions for Stocksum model.
 */
class ScrapreportController extends Controller
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
            'access'=>[
                'class'=>AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new ForbiddenHttpException('คุณไม่ได้รับอนุญาติให้เข้าใช้งาน!');
                },
                'rules'=>[
                    [
                        'allow'=>true,
                        'roles'=>['@'],
                        'matchCallback'=>function($rule,$action){
                            $currentRoute = \Yii::$app->controller->getRoute();
                            if(\Yii::$app->user->can($currentRoute)){
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
        $request_params = \Yii::$app->request->queryParams;
        $param_val = 'page';
        foreach($request_params as $key => $value){
            if (strpos($key, '_tog') !== false) {
                $param_val = $value;
            }
        }
       // echo $param_val;return;
        $searchModel = new ScrapSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
//        $dataProvider->query->andFilterWhere(['activity_type_id'=>15]);
        if($param_val == 'all'){
            $dataProvider->pagination->pageSize = false;
        }else{
            $dataProvider->pagination->pageSize = 300;
        }

        $dataProvider->query->andFilterWhere(['>', 'qty', 0]);
        // $dataProvider->query->andFilterWhere(['is not', 'product_id', new \yii\db\Expression('null')]);
        $dataProvider->setSort(['defaultOrder' => ['trans_date' => SORT_ASC, 'product_id' => SORT_ASC]]);

        $model_bottom = $dataProvider->getModels();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model_bottom' => $model_bottom,
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
