<?php

namespace backend\controllers;

use backend\models\CustomersalehistorySearch;
use backend\models\CustomersalepaySearch;
use backend\models\DeliveryrouteSearch;
use backend\models\PricegroupSearch;
use backend\models\Product;
use Yii;
use backend\models\Customer;
use backend\models\CustomerSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = 50;
        $viewstatus = 0;

        if(\Yii::$app->request->get('viewstatus')!=null){
            $viewstatus = \Yii::$app->request->get('viewstatus');
        }

        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

       // $dataProvider->query->andFilterWhere(['status'=>1]);
        if($viewstatus ==1){
            $dataProvider->query->andFilterWhere(['status'=>$viewstatus]);
        }
        if($viewstatus == 2){
            $dataProvider->query->andFilterWhere(['status'=>0]);
        }

        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
            'viewstatus'=>$viewstatus,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new CustomersalehistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['customer_id' => $id]);

        $searchModel2 = new CustomersalepaySearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
        $dataProvider2->query->andFilterWhere(['customer_id' => $id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $company_id = 0;
        $branch_id = 0;
        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }

        $model = new Customer();

        if ($model->load(Yii::$app->request->post())) {
//            $group = \Yii::$app->request->post('customer_group_id');
//            $route = \Yii::$app->request->post('delivery_route_id');
//            $status = \Yii::$app->request->post('status');
//            $cust_type = \Yii::$app->request->post('customer_type_id');
//
//            $model->customer_group_id = $group;
//            $model->delivery_route_id = $route;
//            $model->customer_type_id = $cust_type;
//            $model->status = $status;
            $photo = UploadedFile::getInstance($model, 'shop_photo');
            if (!empty($photo)) {
                $photo_name = time() . "." . $photo->getExtension();
                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/customer/' . $photo_name);
                $model->shop_photo = $photo_name;
            }

           // echo $model->getLastNo($company_id, $branch_id);
            $fdate = date('Y-m-d');
            $xdate = explode('-', $model->active_date);
            if($xdate != null){
                if(count($xdate) > 1){
                    $fdate = $xdate[2] . '/' . $xdate[1] . '/' . $xdate[0];
                }
            }

            $model->active_date = date('Y-m-d', strtotime($fdate));

            $model->code = $model->getLastNo($company_id, $branch_id);
            $model->sort_name = $model->sort_name == null ? '' : $model->sort_name;
            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            $model->is_show_pos = $model->sort_name == null || $model->sort_name == '' ? 1 : 0;
            if ($model->save(false)) {
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_asset_list = \backend\models\Customerasset::find()->where(['customer_id' => $id])->all();

        if ($model->load(Yii::$app->request->post())) {
//            $group = \Yii::$app->request->post('customer_group_id');
//            $route = \Yii::$app->request->post('delivery_route_id');
//            $status = \Yii::$app->request->post('status');
//            $cust_type = \Yii::$app->request->post('customer_type_id');
//
//            $model->customer_group_id = $group;
//            $model->delivery_route_id = $route;
//            $model->customer_type_id = $cust_type;
//            $model->status = $status;

            $asset_id = \Yii::$app->request->post('line_product_id');
            $asset_qty = \Yii::$app->request->post('line_qty');
            $asset_start_date = \Yii::$app->request->post('line_start_date');
            $removelist = \Yii::$app->request->post('removelist');

            $photo = UploadedFile::getInstance($model, 'shop_photo');
            if (!empty($photo)) {
                $photo_name = time() . "." . $photo->getExtension();
                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/customer/' . $photo_name);
                $model->shop_photo = $photo_name;
            }
            $model->sort_name = $model->sort_name == null ? '' : $model->sort_name;
            $model->is_show_pos = $model->sort_name == null || $model->sort_name == '' ? 1 : 0;
            if ($model->save(false)) {
                if ($asset_id != null) {
                    for ($i = 0; $i <= count($asset_id) - 1; $i++) {
                        if($asset_id[$i] == '' || $asset_id[$i] == null)continue;
                        $model_chk = \backend\models\Customerasset::find()->where(['customer_id' => $model->id, 'product_id' => $asset_id[$i]])->one();
                        if ($model_chk) {
                            // echo 'ok';return;
                            $model_chk->qty = $asset_qty[$i];
                            $model_chk->save(false);
                        } else {
                            $model_asset = new \backend\models\Customerasset();
                            $model_asset->customer_id = $model->id;
                            $model_asset->product_id = $asset_id[$i];
                            $model_asset->qty = $asset_qty[$i];
                            $model_asset->start_date = date('Y-m-d');
                            $model_asset->status = 1;
                            $model_asset->company_id = $model->company_id;
                            $model_asset->branch_id = $model->branch_id;
                            $model_asset->save(false);
                        }

                    }
                }

                if ($removelist != '') {
                    $x = explode(',', $removelist);
                    if (count($x) > 0) {
                        for ($m = 0; $m <= count($x) - 1; $m++) {
                            \common\models\CustomerAsset::deleteAll(['id' => $x[$m]]);
                        }
                    }
                }
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
         //   'model_asset_list' => $model_asset_list,
            'model_asset_list' => $model_asset_list,
        ]);
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $session = Yii::$app->session;
        $session->setFlash('msg', 'ดำเนินการเรียบร้อย');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionDeletephoto()
    {
        $id = \Yii::$app->request->post('delete_id');
        if ($id) {
            $photo = $this->getPhotoName($id);
            if ($photo != '') {
                if (unlink('../web/uploads/images/customer/' . $photo)) {
                    Customer::updateAll(['shop_photo' => ''], ['id' => $id]);
                }
            }

        }
        return $this->redirect(['customer/update', 'id' => $id]);
    }

    public function getPhotoName($id)
    {
        $photo_name = '';
        if ($id) {
            $model = Customer::find()->where(['id' => $id])->one();
            if ($model) {
                $photo_name = $model->shop_photo;
            }
        }
        return $photo_name;
    }
}
