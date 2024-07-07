<?php

namespace backend\controllers;

use backend\models\BranchSearch;
use Yii;
use backend\models\Branchtransfer;
use backend\models\BranchtransferSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BranchtransferController implements the CRUD actions for Branchtransfer model.
 */
class BranchtransferController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Branchtransfer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new BranchtransferSearch();
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
     * Displays a single Branchtransfer model.
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
     * Creates a new Branchtransfer model.
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

        $model = new Branchtransfer();

        if ($model->load(Yii::$app->request->post())) {
            $product = \Yii::$app->request->post('line_product_id');
            $from_company = \Yii::$app->request->post('line_from_company');
            $from_branch = \Yii::$app->request->post('line_from_branch');
            $from_warehouse = \Yii::$app->request->post('line_from_warehouse');
            $to_company = \Yii::$app->request->post('line_to_company');
            $to_branch = \Yii::$app->request->post('line_to_branch');
            $to_warehouse = \Yii::$app->request->post('line_to_warehouse');
            $line_qty = \Yii::$app->request->post('line_qty');

            $x_date = explode('/', $model->trans_date);
            $sale_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $model->trans_date = date('Y-m-d', strtotime($sale_date));
            $model->journal_no = $model->getLastNo($company_id, $branch_id);
            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            if ($model->save()) {
                if ($product != null && $from_company != null && $to_company != null && $to_branch != null && $to_warehouse != null) {
                    for ($i = 0; $i <= count($product) - 1; $i++) {
                        if($line_qty[$i]<=0 || $line_qty == null)continue;

                        $model_line = new \common\models\BranchTransferLine();
                        $model_line->journal_id = $model->id;
                        $model_line->product_id = $product[$i];
                        $model_line->from_company_id = $from_company[$i];
                        $model_line->from_branch_id = $from_branch[$i];
                        $model_line->from_warehouse_id = $from_warehouse[$i];
                        $model_line->to_company_id = $to_company[$i];
                        $model_line->to_branch_id = $to_branch[$i];
                        $model_line->to_warehouse_id = $to_warehouse[$i];
                        $model_line->qty = $line_qty[$i];
                        if ($model_line->save()) {
                            // update from
                            $model_stock_trans = new \backend\models\Stocktrans();
                            $model_stock_trans->journal_no = $model->getLastNo($company_id, $branch_id);
                            $model_stock_trans->trans_date = date('Y-m-d H:i:s');
                            $model_stock_trans->product_id = $product[$i];
                            $model_stock_trans->warehouse_id = $from_warehouse[$i];
                            $model_stock_trans->stock_type = 2;
                            $model_stock_trans->activity_type_id = 19;
                            $model_stock_trans->trans_ref_id = $model->id;
                            $model_stock_trans->qty = $line_qty[$i];
                            if($model_stock_trans->save()){
                                $model_from_stock = \backend\models\Stocksum::find()->where(['warehouse_id'=>$from_warehouse[$i],'product_id'=>$product[$i]])->one();
                                if($model_from_stock){
                                    $model_from_stock->qty = $model_from_stock->qty - (int)$line_qty[$i];
                                    $model_from_stock->save(false);
                                }
                            }

                            // update to
                            $model_stock_trans2 = new \backend\models\Stocktrans();
                            $model_stock_trans2->journal_no = $model->getLastNo($company_id, $branch_id);
                            $model_stock_trans2->trans_date = date('Y-m-d H:i:s');
                            $model_stock_trans2->product_id = $product[$i];
                            $model_stock_trans2->warehouse_id = $to_warehouse[$i];
                            $model_stock_trans2->stock_type = 1;
                            $model_stock_trans2->activity_type_id = 19;
                            $model_stock_trans2->trans_ref_id = $model->id;
                            $model_stock_trans2->qty = $line_qty[$i];
                            if($model_stock_trans2->save()){

                                // update to
                                $model_to_stock = \backend\models\Stocksum::find()->where(['warehouse_id'=>$to_warehouse[$i],'product_id'=>$product[$i]])->one();
                                if($model_to_stock){
                                    $model_to_stock->qty = $model_to_stock->qty + (int)$line_qty[$i];
                                    $model_to_stock->save(false);
                                }else{
                                    $model_new = new \backend\models\Stocksum();
                                    $model_new->warehouse_id = $to_warehouse[$i];
                                    $model_new->product_id = $product[$i];
                                    $model_new->qty = $line_qty[$i];
                                    $model_new->save(false);
                                }
                            }
                        }
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Branchtransfer model.
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

    public function actionDelete($id)
    {

        $this->findModel($id)->delete();
        \common\models\BranchTransferLine::deleteAll(['journal_id'=>$id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Branchtransfer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Branchtransfer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Branchtransfer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetbranch(){
        $id = \Yii::$app->request->post('company_id');
        $html = '';
        if($id){
            $model = \backend\models\Branch::find()->where(['company_id'=>$id])->all();
            if($model){
                $html='<option value="-1">--เลือก--</option>';
                foreach ($model as $value){
                    $html.='<option value="'.$value->id.'">'.$value->name.'</option>';
                }
            }else{
                $html='<option value="-1">--เลือก--</option>';
            }
        }
        echo $html;
    }
    public function actionGetwarehouse(){
        $id = \Yii::$app->request->post('branch_id');
        $html = '';
        if($id){
            $model = \backend\models\Warehouse::find()->where(['branch_id'=>$id])->all();
            if($model){
                $html='<option value="-1">--เลือก--</option>';
                foreach ($model as $value){
                    $html.='<option value="'.$value->id.'">'.$value->name.'</option>';
                }
            }else{
                $html='<option value="-1">--เลือก--</option>';
            }
        }
        echo $html;
    }
}
