<?php

namespace backend\controllers;

use backend\models\CustomerSearch;
use Yii;
use backend\models\Customerrequest;
use backend\models\CustomerrequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CustomerrequestController implements the CRUD actions for Customerrequest model.
 */
class CustomerrequestController extends Controller
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
        ];
    }

    /**
     * Lists all Customerrequest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $viewstatus = 0;

        if (\Yii::$app->request->get('viewstatus') != null) {
            $viewstatus = \Yii::$app->request->get('viewstatus');
        }
        $searchModel = new CustomerrequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
            'viewstatus' => $viewstatus,
        ]);
    }

    /**
     * Displays a single Customerrequest model.
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
     * Creates a new Customerrequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customerrequest();

        if ($model->load(Yii::$app->request->post())) {


            //$payment_type_id = \Yii::$app->request->post('payment_type_id');

            $product_id = \Yii::$app->request->post('product_id');
            $product_qty = \Yii::$app->request->post('product_qty');

            $uploaded_1 = UploadedFile::getInstancesByName('docfile');
            $uploaded_2 = UploadedFile::getInstanceSByName('shopfile');

            $attach_doc = \Yii::$app->request->post('attatch_doc');

//            if (!empty($uploaded_1)) {
//                echo "has file";
//            } else {
//                echo "no file";
//            }
//            return;

            //  print_r($attach_doc);return;

            $m_emp_date = date('Y-m-d');
            $x_emp_date = explode('/', $model->market_emp_date);
            if (count($x_emp_date) > 1) {
                $m_emp_date = $x_emp_date[2] . '/' . $x_emp_date[1] . '/' . $x_emp_date[0];
            }
            $t_date = date('Y-m-d');

            $x_date = explode('/', $model->trans_date);
            if (count($x_date) > 1) {
                $t_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }

            $start_date = date('Y-m-d');
            $xs_date = explode('/', $model->start_date);
            if (count($xs_date) > 1) {
                $start_date = $xs_date[2] . '/' . $xs_date[1] . '/' . $xs_date[0];
            }


            $model->trans_date = date('Y-m-d', strtotime($t_date));
            $model->start_date = date('Y-m-d', strtotime($start_date));
            $model->market_emp_date = date('Y-m-d', strtotime($m_emp_date));
            $model->journal_no = $model::getLastNo();
            $model->marget_emp_id = \Yii::$app->user->id;
            $model->is_approve = 0;
            $model->is_shop_place = 1;
            // $model->payment_method_id = $payment_type_id;
            if ($model->save(false)) {
                if ($product_id != null) {
                    for ($i = 0; $i <= count($product_id) - 1; $i++) {
                        if ($product_qty[$i] == null) {
                            continue;
                        } else {
                            // request product
                            $model_product = new \common\models\CustomerRequestProduct();
                            $model_product->customer_req_id = $model->id;
                            $model_product->product_id = $product_id[$i];
                            $model_product->qty = $product_qty[$i];
                            $model_product->save(false);
                        }


                    }
                }

                if (!empty($uploaded_1)) {
                    foreach ($uploaded_1 as $file) {
                        $file_name = "doc_" . time() . "." . $file->getExtension();
                        $file->saveAs(Yii::getAlias('@backend') . '/web/uploads/files/customerrequest/' . $file_name);

                        $model_doc = new \common\models\CustomerRequestDoc();
                        $model_doc->customer_req_id = $model->id;
                        $model_doc->doc_id = 1;
                        $model_doc->doc_name = $file_name;
                        $model_doc->save(false);
                    }
                }

                if (!empty($uploaded_2)) {
                    foreach ($uploaded_2 as $file) {
                        $file_name = "shop_" . time() . "." . $file->getExtension();
                        $file->saveAs(Yii::getAlias('@backend') . '/web/uploads/files/customerrequest/' . $file_name);

                        $model_doc = new \common\models\CustomerRequestDoc();
                        $model_doc->customer_req_id = $model->id;
                        $model_doc->doc_id = 2;
                        $model_doc->doc_name = $file_name;
                        $model_doc->save(false);
                    }
                }

                if($attach_doc != null){
                    \common\models\CustomerRequestAttatchDocSelect::deleteAll(['customer_request_id' => $model->id]);
                    for($x=0;$x<=count($attach_doc)-1;$x++){
                    $model_doc = new \common\models\CustomerRequestAttatchDocSelect();
                    $model_doc->customer_request_id = $model->id;
                    $model_doc->customer_attatch_doc_id = $attach_doc[$x];
                    $model_doc->save(false);
                    }
                }else{
                    \common\models\CustomerRequestAttatchDocSelect::deleteAll(['customer_request_id' => $model->id]);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Customerrequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_product = \common\models\CustomerRequestProduct::find()->where(['customer_req_id' => $model->id])->all();
        $model_doc = \common\models\CustomerRequestDoc::find()->where(['customer_req_id' => $model->id])->all();
        $model_attach_select = \common\models\CustomerRequestAttatchDocSelect::find()->where(['customer_request_id' => $model->id])->all();

        if ($model->load(Yii::$app->request->post())) {

            $product_id = \Yii::$app->request->post('product_id');
            $product_qty = \Yii::$app->request->post('product_qty');

            $m_emp_date = date('Y-m-d');
            $x_emp_date = explode('/', $model->market_emp_date);
            if (count($x_emp_date) > 1) {
                $m_emp_date = $x_emp_date[2] . '/' . $x_emp_date[1] . '/' . $x_emp_date[0];
            }
            $t_date = date('Y-m-d');

            $x_date = explode('/', $model->trans_date);
            if (count($x_date) > 1) {
                $t_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }

            $start_date = date('Y-m-d');
            $xs_date = explode('/', $model->start_date);
            if (count($xs_date) > 1) {
                $start_date = $xs_date[2] . '/' . $xs_date[1] . '/' . $xs_date[0];
            }


            $model->trans_date = date('Y-m-d', strtotime($t_date));
            $model->start_date = date('Y-m-d', strtotime($start_date));
            $model->market_emp_date = date('Y-m-d', strtotime($m_emp_date));
            if ($model->save(false)) {
                if ($product_id != null) {
                    \common\models\CustomerRequestProduct::deleteAll(['customer_req_id' => $model->id]);
                    for ($i = 0; $i <= count($product_id) - 1; $i++) {
                        if ($product_qty[$i] == null) {
                            continue;
                        } else {
                            // request product
                            $model_product = new \common\models\CustomerRequestProduct();
                            $model_product->customer_req_id = $model->id;
                            $model_product->product_id = $product_id[$i];
                            $model_product->qty = $product_qty[$i];
                            $model_product->save(false);
                        }
                    }
                }
                $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'model_product' => $model_product,
            'model_doc' => $model_doc,
            'model_attach_select' => $model_attach_select
        ]);
    }

    /**
     * Deletes an existing Customerrequest model.
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
     * Finds the Customerrequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customerrequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customerrequest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionApprove()
    {
        $id = \Yii::$app->request->post('request_id');
        if ($id > 0) {
            $model = $this->findModel($id);
            if ($model) {
                $model->is_approve = 1; // approve
                $model->approve_date = date('Y-m-d');
                $model->approve_emp_id = \Yii::$app->user->id;
                $model->save(false);
                \Yii::$app->session->setFlash('msg-success', 'Approve successfully.');
            }
        }
        return $this->redirect(['index']);
    }

    public function actionConvertcustomer()
    {
        $company_id = 0;
        $branch_id = 0;
        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }
        $id = \Yii::$app->request->post('request_id');
        if ($id > 0) {
            $model = $this->findModel($id);
            if ($model) {

                $model_check_dup = \backend\models\Customer::find()->where(['name' => $model->company_name])->count();
                if ($model_check_dup > 0) {
                    \Yii::$app->session->setFlash('msg-danger', 'Customer name already exist.');
                    return $this->redirect(['update', 'id' => $id]);
                }


                $model_customer = new \backend\models\Customer();
                $model_customer->code = $model_customer::getLastNo($company_id, $branch_id);
                $model_customer->name = $model->company_name;
                $model_customer->delivery_route_id = $model->route_id;
                $model_customer->route_num = $model->route_num;
                $model_customer->phone = $model->phone;
                $model_customer->status = 1;
                $model_customer->company_id = 1;
                $model_customer->branch_id = 1;
                $model_customer->sale_id = \backend\models\Employee::findEmpIdFromUserId($model->created_by);
                $model_customer->cus_description = $model->remark;
                $model_customer->contact_name = $model->customer_name;
                $model_customer->active_date = date('Y-m-d');
                $model_customer->idcard_no = $model->idcard_no;
                if ($model_customer->save(false)) {
                    //create address
                    $model_address_info = new \backend\models\AddressInfo();
                    $model_address_info->party_type_id = 2;
                    $model_address_info->party_id = $model_customer->id;
                    $model_address_info->address = $model->address;
                    $model_address_info->street = '';
                    $model_address_info->district_id = $model->district_id;
                    $model_address_info->city_id = $model->city_id;
                    $model_address_info->province_id = $model->province_id;
                    $model_address_info->zipcode = '';
                    $model_address_info->status = 1;
                    $model_address_info->address_type_id = 2;
                    $model_address_info->save(false);


                    // update customer ref id
                    $model->customer_ref_id = $model_customer->id;
                    //  $model->status = 1;
//                    $model->company_id = 1;
//                    $model->branch_id = 1;
                    $model->is_approve = 100; // complete create customer status
                    $model->save(false);
                }
                \Yii::$app->session->setFlash('msg-success', 'Customer created successfully.');
            }
        }

        return $this->redirect(['update', 'id' => $id]);
    }

    public function actionPrint()
    {
        $id = \Yii::$app->request->get('id');
        $model = $this->findModel($id);
        $model_product = \common\models\CustomerRequestProduct::find()->where(['customer_req_id' => $id])->all();
        $model_doc = \common\models\CustomerRequestDoc::find()->where(['customer_req_id' => $id])->all();
        $model_asset = \backend\models\Customerasset::find()->where(['customer_id' => $model->customer_ref_id])->all();
        $model_attach_select = \common\models\CustomerRequestAttatchDocSelect::find()->where(['customer_request_id' => $id])->all();
        return $this->render('_print', [
            'model' => $model,
            'model_product' => $model_product,
            'model_doc' => $model_doc,
            'model_asset' => $model_asset,
            'model_attach_select' => $model_attach_select
        ]);
    }
}
