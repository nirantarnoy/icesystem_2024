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
        $viewstatus = 1;

        if(\Yii::$app->request->get('viewstatus')!=null){
            $viewstatus = \Yii::$app->request->get('viewstatus');
        }

        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
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
//    public function actionCreate()
//    {
//        $company_id = 0;
//        $branch_id = 0;
//        if (!empty(\Yii::$app->user->identity->company_id)) {
//            $company_id = \Yii::$app->user->identity->company_id;
//        }
//        if (!empty(\Yii::$app->user->identity->branch_id)) {
//            $branch_id = \Yii::$app->user->identity->branch_id;
//        }
//
//        $model = new Customer();
//
//        if ($model->load(Yii::$app->request->post())) {
////            $group = \Yii::$app->request->post('customer_group_id');
////            $route = \Yii::$app->request->post('delivery_route_id');
////            $status = \Yii::$app->request->post('status');
////            $cust_type = \Yii::$app->request->post('customer_type_id');
////
////            $model->customer_group_id = $group;
////            $model->delivery_route_id = $route;
////            $model->customer_type_id = $cust_type;
////            $model->status = $status;
//            $photo = UploadedFile::getInstance($model, 'shop_photo');
//            if (!empty($photo)) {
//                $photo_name = time() . "." . $photo->getExtension();
//                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/customer/' . $photo_name);
//                $model->shop_photo = $photo_name;
//            }
//                 $fdate = date('Y-m-d');
//            $xdate = explode('-', $model->active_date);
//            if($xdate != null){
//                if(count($xdate) > 1){
//                    $fdate = $xdate[2] . '/' . $xdate[1] . '/' . $xdate[0];
//                }
//            }
//
//            $model->active_date = date('Y-m-d', strtotime($fdate));
//
//
//           // echo $model->getLastNo($company_id, $branch_id);
//
//            $model->code = $model->getLastNo($company_id, $branch_id);
//            $model->sort_name = $model->sort_name == null ? '' : $model->sort_name;
//            $model->company_id = $company_id;
//            $model->branch_id = $branch_id;
//            $model->is_show_pos = $model->sort_name == null || $model->sort_name == '' ? 1 : 0;
//            if ($model->save(false)) {
//                $session = Yii::$app->session;
//                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
//                return $this->redirect(['index']);
//            }
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

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

            $fdate2 = date('Y-m-d');
            $xdate2 = explode('-', $model->cancel_use_date);
            if($xdate2 != null){
                if(count($xdate2) > 1){
                    $fdate2 = $xdate2[2] . '/' . $xdate2[1] . '/' . $xdate2[0];
                }
            }

            $model->active_date = date('Y-m-d', strtotime($fdate));
            $model->cancel_use_date = date('Y-m-d', strtotime($fdate2));

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
        $model_delivery_address = \common\models\AddressInfo::find()->where(['party_id' => $id, 'address_type_id' => 2])->one();

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


            $party_type = 2;
            $address = \Yii::$app->request->post('cus_address');
            $street = \Yii::$app->request->post('cus_street');
            $district_id = \Yii::$app->request->post('district_id');
            $city_id = \Yii::$app->request->post('city_id');
            $province_id = \Yii::$app->request->post('province_id');
            $zipcode = \Yii::$app->request->post('zipcode');

            $address2 = \Yii::$app->request->post('cus_address2');
            $street2 = \Yii::$app->request->post('cus_street2');
            $district_id2 = \Yii::$app->request->post('district_id2');
            $city_id2 = \Yii::$app->request->post('city_id2');
            $province_id2 = \Yii::$app->request->post('province_id2');
            $zipcode2 = \Yii::$app->request->post('zipcode2');


            $asset_id = \Yii::$app->request->post('line_product_id');
            $asset_qty = \Yii::$app->request->post('line_qty');
            $asset_start_date = \Yii::$app->request->post('line_start_date');
            $removelist = \Yii::$app->request->post('removelist');

            $contact_file = UploadedFile::getInstanceByName('contact_file');
            $old_contact_file = \Yii::$app->request->post('old_contact_file');

            $uploaded_1 = UploadedFile::getInstancesByName('docfile');
            $uploaded_2 = UploadedFile::getInstanceSByName('shopfile');


            $photo = UploadedFile::getInstance($model, 'shop_photo');
            if (!empty($photo)) {
                $photo_name = time() . "." . $photo->getExtension();
                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/customer/' . $photo_name);
                $model->shop_photo = $photo_name;
            }

            if($contact_file != null){
                $contact_file_name = 'cus_'.$id.'_'.time() . "." . $contact_file->getExtension();
                $contact_file->saveAs(Yii::getAlias('@backend') . '/web/uploads/files/customers/' . $contact_file_name);
                $model->contact_file = $contact_file_name;

                if($old_contact_file != null){
                    if(file_exists(Yii::getAlias('@backend') . '/web/uploads/files/customers/' . $old_contact_file)){
                        unlink(Yii::getAlias('@backend') . '/web/uploads/files/customers/' . $old_contact_file);
                    }
                }
            }



            $fdate = date('Y-m-d');
            $xdate = explode('-', $model->active_date);
            if($xdate != null){
                if(count($xdate) > 1){
                    $fdate = $xdate[2] . '/' . $xdate[1] . '/' . $xdate[0];
                }
            }

            $fdate2 = date('Y-m-d');
            $xdate2 = explode('-', $model->cancel_use_date);
            if($xdate2 != null){
                if(count($xdate2) > 1){
                    $fdate2 = $xdate2[2] . '/' . $xdate2[1] . '/' . $xdate2[0];
                }
            }

          //  $model->active_date = date('Y-m-d', strtotime($fdate));
            $model->cancel_use_date = $model->cancel_use_date == null ? null:date('Y-m-d', strtotime($fdate2));

            $model->sort_name = $model->sort_name == null ? '' : $model->sort_name;
            $model->is_show_pos = $model->sort_name == null || $model->sort_name == '' ? 1 : 0;
            $model->active_date = date('Y-m-d',strtotime($fdate));
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

                if (!empty($uploaded_1)) {
                    foreach ($uploaded_1 as $file) {
                        $file_name = "doc_" . time() . "." . $file->getExtension();
                        $file->saveAs(Yii::getAlias('@backend') . '/web/uploads/files/customerrequest/' . $file_name);

                        $model_doc = new \common\models\CustomerRequestDoc();
                        $model_doc->customer_req_id = 0;
                        $model_doc->doc_id = 1;
                        $model_doc->doc_name = $file_name;
                        $model_doc->customer_id = $model->id;
                        $model_doc->save(false);
                    }
                }

                if (!empty($uploaded_2)) {
                    foreach ($uploaded_2 as $file) {
                        $file_name = "shop_" . time() . "." . $file->getExtension();
                        $file->saveAs(Yii::getAlias('@backend') . '/web/uploads/files/customerrequest/' . $file_name);

                        $model_doc = new \common\models\CustomerRequestDoc();
                        $model_doc->customer_req_id = 0;
                        $model_doc->doc_id = 2;
                        $model_doc->doc_name = $file_name;
                        $model_doc->customer_id = $model->id;
                        $model_doc->save(false);
                    }
                }






                if ($party_type) {
//                    echo 'dd'; return
                    $address_chk = \common\models\AddressInfo::find()->where(['party_id' => $model->id, 'party_type_id' => $party_type, 'address_type_id' => 1])->one();
//                    echo 'dd'; return;
                    if ($address_chk) {
                        $address_chk->party_type_id = $party_type;
                        $address_chk->address = $address;
                        $address_chk->street = $street;
                        $address_chk->district_id = $district_id;
                        $address_chk->city_id = $city_id;
                        $address_chk->province_id = $province_id;
                        $address_chk->zipcode = $zipcode;
                        $address_chk->status = 1;
                        if ($address_chk->save(false)) {

                        }
                    } else {
                        $new_address = new \common\models\AddressInfo();
                        $new_address->party_type_id = $party_type;
                        $new_address->party_id = $model->id;
                        $new_address->address = $address;
                        $new_address->street = $street;
                        $new_address->district_id = $district_id;
                        $new_address->city_id = $city_id;
                        $new_address->province_id = $province_id;
                        $new_address->zipcode = $zipcode;
                        $new_address->status = 1;
                        $new_address->address_type_id = 1;
                        if ($new_address->save(false)) {

                        }
                    }

                    $address_chk2 = \common\models\AddressInfo::find()->where(['party_id' => $model->id, 'party_type_id' => $party_type, 'address_type_id' => 2])->one();
                    if ($address_chk2) {
                        $address_chk2->address = $address2;
                        $address_chk2->street = $street2;
                        $address_chk2->district_id = $district_id2;
                        $address_chk2->city_id = $city_id2;
                        $address_chk2->province_id = $province_id2;
                        $address_chk2->zipcode = $zipcode2;
                        $address_chk2->status = 1;
                        if ($address_chk2->save(false)) {

                        }
                    } else {
                        $cus_address2 = new \common\models\AddressInfo();
                        $cus_address2->party_type_id = $party_type;
                        $cus_address2->party_id = $model->id;
                        $cus_address2->address = $address2;
                        $cus_address2->street = $street2;
                        $cus_address2->district_id = $district_id2;
                        $cus_address2->city_id = $city_id2;
                        $cus_address2->province_id = $province_id2;
                        $cus_address2->zipcode = $zipcode2;
                        $cus_address2->status = 1;
                        $cus_address2->address_type_id = 2; // 2 = delivery
                        if ($cus_address2->save(false)) {

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
            'model_delivery_address'=>$model_delivery_address,
        ]);
    }

//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//        $model_asset_list = \backend\models\Customerasset::find()->where(['customer_id' => $id])->all();
//        $model_delivery_address = \common\models\AddressInfo::find()->where(['party_id' => $id, 'address_type_id' => 2])->one();
//        if ($model->load(Yii::$app->request->post())) {
////            $group = \Yii::$app->request->post('customer_group_id');
////            $route = \Yii::$app->request->post('delivery_route_id');
////            $status = \Yii::$app->request->post('status');
////            $cust_type = \Yii::$app->request->post('customer_type_id');
////
////            $model->customer_group_id = $group;
////            $model->delivery_route_id = $route;
////            $model->customer_type_id = $cust_type;
////            $model->status = $status;
//
//            $asset_id = \Yii::$app->request->post('line_product_id');
//            $asset_qty = \Yii::$app->request->post('line_qty');
//            $asset_start_date = \Yii::$app->request->post('line_start_date');
//            $removelist = \Yii::$app->request->post('removelist');
//
//            $photo = UploadedFile::getInstance($model, 'shop_photo');
//            if (!empty($photo)) {
//                $photo_name = time() . "." . $photo->getExtension();
//                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/customer/' . $photo_name);
//                $model->shop_photo = $photo_name;
//            }
//
//            $fdate = date('Y-m-d');
//            $xdate = explode('-', $model->active_date);
//            if($xdate != null){
//                if(count($xdate) > 1){
//                    $fdate = $xdate[2] . '/' . $xdate[1] . '/' . $xdate[0];
//                }
//            }
//
//         //   $model->active_date = date('Y-m-d', strtotime($fdate));
//
//            $model->sort_name = $model->sort_name == null ? '' : $model->sort_name;
//            $model->is_show_pos = $model->sort_name == null || $model->sort_name == '' ? 1 : 0;
//            if ($model->save(false)) {
//                if ($asset_id != null) {
//                    for ($i = 0; $i <= count($asset_id) - 1; $i++) {
//                        $model_chk = \backend\models\Customerasset::find()->where(['customer_id' => $model->id, 'product_id' => $asset_id[$i]])->one();
//                        if ($model_chk) {
//                            // echo 'ok';return;
//                            $model_chk->qty = $asset_qty[$i];
//                            $model_chk->save(false);
//                        } else {
//                            $model_asset = new \backend\models\Customerasset();
//                            $model_asset->customer_id = $model->id;
//                            $model_asset->product_id = $asset_id[$i];
//                            $model_asset->qty = $asset_qty[$i];
//                            $model_asset->start_date = date('Y-m-d');
//                            $model_asset->status = 1;
//                            $model_asset->company_id = $model->company_id;
//                            $model_asset->branch_id = $model->branch_id;
//                            $model_asset->save(false);
//                        }
//
//                    }
//                }
//
//                if ($removelist != '') {
//                    $x = explode(',', $removelist);
//                    if (count($x) > 0) {
//                        for ($m = 0; $m <= count($x) - 1; $m++) {
//                            \common\models\CustomerAsset::deleteAll(['id' => $x[$m]]);
//                        }
//                    }
//                }
//                $session = Yii::$app->session;
//                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
//                return $this->redirect(['index']);
//            }
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//         //   'model_asset_list' => $model_asset_list,
//            'model_asset_list' => $model_asset_list,
//            'model_delivery_address'=>$model_delivery_address,
//        ]);
//    }

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

    public function actionGetcustasset()
    {
        $id = \Yii::$app->request->post('id');
        $html = '';
        if ($id) {
            $model = \common\models\CustomerAsset::find()->where(['customer_id' => $id])->orderBy(['product_id' => SORT_ASC])->all();
            if ($model) {
                foreach ($model as $value) {
                    $html .= '<tr>';
                    $html .= '<td>' . \backend\models\Assetsitem::findCode($value->product_id) . '</td>';
                    $html .= '<td>' . $value->qty . '</td>';
                    $html .= '</tr>';
                }
            }
        }
        echo $html;
    }


    public
    function actionShowcity($id)
    {
        $model = \common\models\Amphur::find()->where(['PROVINCE_ID' => $id])->all();

        if (count($model) > 0) {
            echo "<option>--- เลือกอำเภอ ---</option>";
            foreach ($model as $value) {

                echo "<option value='" . $value->AMPHUR_ID . "'>$value->AMPHUR_NAME</option>";

            }
        } else {
            echo "<option>-</option>";
        }
    }

    public
    function actionShowdistrict($id)
    {
        $model = \common\models\District::find()->where(['AMPHUR_ID' => $id])->all();

        if (count($model) > 0) {
            foreach ($model as $value) {

                echo "<option value='" . $value->DISTRICT_ID . "'>$value->DISTRICT_NAME</option>";

            }
        } else {
            echo "<option>-</option>";
        }
    }

    public function actionShowzipcode($id)
    {
        $model = \common\models\Amphur::find()->where(['AMPHUR_ID' => $id])->one();
//        echo $id;
        if ($model) {
            echo $model->POSTCODE;
//            echo '1110';
        } else {
            echo "";
        }
//        echo '111';
    }
}
