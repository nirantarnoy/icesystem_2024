<?php

namespace backend\controllers;

use backend\models\LocationSearch;
use backend\models\PlansummarySearch;
use Yii;
use backend\models\Production;
use backend\models\ProductionSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductionController implements the CRUD actions for Production model.
 */
class ProductionController extends Controller
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
                            $currentRoute = Yii::$app->controller->getRoute();
                            if(Yii::$app->user->can($currentRoute)){
                                return true;
                            }
                        }
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Production models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new ProductionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Production model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Production model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Production();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Production model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionCreatefromplan(){
        $from_date = \Yii::$app->request->post('from_date');
        $to_date = \Yii::$app->request->post('to_date');

        $company_id = 0;
        $branch_id = 0;
        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }

        $model_plan = \common\models\QueryPlan::find()->select(['product_id','SUM(qty) as qty'])->where(['>=','date(trans_date)',date('Y-m-d')])->andFilterWhere(['<=','date(trans_date)',date('Y-m-d')])->groupBy('product_id')->all();
        if($model_plan){
            foreach ($model_plan as $value){
                $model_prod = new \backend\models\Production();
                $model_prod->prod_no = $model_prod::getLastNo($company_id,$branch_id,13); // 13 WO
                $model_prod->plan_id = 0;//$plan_id;
                $model_prod->prod_date = date('Y-m-d H:i:s');
                $model_prod->product_id = $value->product_id;
                $model_prod->qty = $value->qty;
                $model_prod->remain_qty = $value->qty;
                $model_prod->company_id = $company_id;
                $model_prod->branch_id = $branch_id;
                $model_prod->status = 1;
                $model_prod->save(false);
            }
        }

    }

    /**
     * Deletes an existing Production model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
     //   $this->findModel($id)->delete();
        $model = \backend\models\Production::find()->where(['id' => $id])->one();
        if ($model) {
            $customer_id = $model->customer_id;
            $model_line = \common\models\ProductionLine::find()->where(['prod_id' => $id])->one();
            if ($model_line) {
                if (\common\models\PaymentReceiveLine::deleteAll(['payment_receive_id' => $id])) {
                    $this->findModel($id)->delete();
                }
            }else{
                $this->findModel($id)->delete();
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Production model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Production the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Production::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
