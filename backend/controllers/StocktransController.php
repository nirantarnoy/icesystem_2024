<?php

namespace backend\controllers;

use Yii;
use backend\models\Stocktrans;
use backend\models\StocktransSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StocktransController implements the CRUD actions for Stocktrans model.
 */
class StocktransController extends Controller
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

    /**
     * Lists all Stocktrans models.
     * @return mixed
     */
    public function actionIndex()
    {
        $view_type_main = \Yii::$app->request->get('view_type');
        $request_params = \Yii::$app->request->queryParams;
        $param_val = 'page';
        foreach($request_params as $key => $value){
            if (strpos($key, '_tog') !== false) {
                $param_val = $value;
            }
        }
        $searchModel = new StocktransSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if($param_val == 'all'){
            $dataProvider->pagination->pageSize = false;
        }else{
            $dataProvider->pagination->pageSize = 300;
        }
//        if($view_type_main == 1){
//            $dataProvider->pagination->pageSize = 300;
//        }else{
//            $dataProvider->pagination->pageSize = false;
//        }
        $dataProvider->setSort(['defaultOrder'=>['id'=>SORT_DESC]]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'view_type_main' => $view_type_main,
        ]);
    }

    /**
     * Displays a single Stocktrans model.
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
     * Creates a new Stocktrans model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $company_id = 1;
        $branch_id = 1;

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }

        $trans_date = \Yii::$app->request->post('prodrecdate');
        $wh_id = \Yii::$app->request->post('line_warehouse_id');
        $prodid = \Yii::$app->request->post('line_item_id');
        $qty = \Yii::$app->request->post('line_qty');

        //($wh_id);return;

        if($wh_id != null){
            $model_journal = new \backend\models\Stockjournal();
            $model_journal->journal_no = $model_journal->getLastNoBackend($company_id,$branch_id);
            $model_journal->trans_date = date('Y-m-d H:i:s');
            $model_journal->company_id = $company_id;
            $model_journal->branch_id = $branch_id;
            $model_journal->production_type = 15;
            if($model_journal->save(false)){
                for($i=0;$i<=count($wh_id)-1;$i++){
                    $model = new \backend\models\Stocktrans();
                    $model->journal_no = $model_journal->journal_no;
                    $model->journal_id = $model_journal->id;
                    $model->trans_date = date('Y-m-d H:i:s');
                    $model->product_id = $prodid[$i];
                    $model->qty = $qty[$i];
                    $model->warehouse_id = $wh_id[$i];
                    $model->stock_type = 1;
                    $model->activity_type_id = 15; // 15 prod rec
                    $model->company_id = $company_id;
                    $model->branch_id = $branch_id;
                    $model->created_by = \Yii::$app->user->id;
                    if($model->save()){
                        $this->updateSummary($prodid[$i],$wh_id[$i],$qty[$i],$company_id,$branch_id);
                    }
                }
            }

            $model = \backend\models\Stockjournal::find()->where(['id' => $model_journal->id])->one();
            $model_line = \backend\models\Stocktrans::find()->where(['journal_id' => $model_journal->id])->all();

            $session = \Yii::$app->session;
            $session->setFlash('msg-index', 'slip_prodrec_index.pdf');
            $session->setFlash('after-save', true);

            $this->renderPartial('_printtoindex', ['model' => $model, 'model_line' => $model_line, 'change_amount' => 0]);

        }

    //    return $this->redirect(['stocktrans/index']);
        return $this->redirect(['productionrec/index']);
    }

    public function updateSummary($product_id, $wh_id, $qty,$company_id,$branch_id){
        if($wh_id != null && $product_id != null && $qty > 0){
            $model = \backend\models\Stocksum::find()->where(['warehouse_id'=>$wh_id,'product_id'=>$product_id])->one();
            if($model){
                $model->qty = ($model->qty + (int)$qty);
                $model->save(false);
            }else{
                $model_new = new \backend\models\Stocksum();
                $model_new->warehouse_id = $wh_id;
                $model_new->product_id = $product_id;
                $model_new->company_id = $company_id;
                $model_new->branch_id = $branch_id;
                $model_new->qty = $qty;
                $model_new->save(false);
            }
        }
    }

    /**
     * Updates an existing Stocktrans model.
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

    /**
     * Deletes an existing Stocktrans model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Stocktrans model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stocktrans the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stocktrans::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
