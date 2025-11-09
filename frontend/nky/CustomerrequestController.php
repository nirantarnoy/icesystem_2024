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
//                if ($product_id != null) {
//                    for ($i = 0; $i <= count($product_id) - 1; $i++) {
//                        if ($product_qty[$i] == null) {
//                            continue;
//                        } else {
//                            // request product
//                            $model_product = new \common\models\CustomerRequestProduct();
//                            $model_product->customer_req_id = $model->id;
//                            $model_product->product_id = $product_id[$i];
//                            $model_product->qty = $product_qty[$i];
//                            $model_product->save(false);
//                        }
//
//
//                    }
//                }
//
////                if (!empty($uploaded_1)) {
////                    foreach ($uploaded_1 as $file) {
////                        $file_name = "doc_" . time() . "." . $file->getExtension();
////                        $file->saveAs(Yii::getAlias('@backend') . '/web/uploads/files/customerrequest/' . $file_name);
////
////                        $model_doc = new \common\models\CustomerRequestDoc();
////                        $model_doc->customer_req_id = $model->id;
////                        $model_doc->doc_id = 1;
////                        $model_doc->doc_name = $file_name;
////                        $model_doc->save(false);
////                    }
////                }
////
////                if (!empty($uploaded_2)) {
////                    foreach ($uploaded_2 as $file) {
////                        $file_name = "shop_" . time() . "." . $file->getExtension();
////                        $file->saveAs(Yii::getAlias('@backend') . '/web/uploads/files/customerrequest/' . $file_name);
////
////                        $model_doc = new \common\models\CustomerRequestDoc();
////                        $model_doc->customer_req_id = $model->id;
////                        $model_doc->doc_id = 2;
////                        $model_doc->doc_name = $file_name;
////                        $model_doc->save(false);
////                    }
////                }
//
//                if($attach_doc != null){
//                    \common\models\CustomerRequestAttatchDocSelect::deleteAll(['customer_request_id' => $model->id]);
//                    for($x=0;$x<=count($attach_doc)-1;$x++){
//                    $model_doc = new \common\models\CustomerRequestAttatchDocSelect();
//                    $model_doc->customer_request_id = $model->id;
//                    $model_doc->customer_attatch_doc_id = $attach_doc[$x];
//                    $model_doc->save(false);
//                    }
//                }else{
//                    \common\models\CustomerRequestAttatchDocSelect::deleteAll(['customer_request_id' => $model->id]);
//                }
//
//
//                // เตรียมข้อมูลสำหรับ batch insert
//                if (!empty($_POST['standard_items'])) {
//                    $values = [];
//                    $params = [];
//                    $counter = 0;
//
//                    foreach ($_POST['standard_items'] as $standard_id => $item_ids) {
//                        if (!empty($item_ids)) {
//                            foreach ($item_ids as $item_id) {
//                                $values[] = "(:cus_req_id_{$counter}, :standard_id_{$counter}, :item_id_{$counter})";
//                                $params[":cus_req_id_{$counter}"] = $model->id;
//                                $params[":standard_id_{$counter}"] = $standard_id;
//                                $params[":item_id_{$counter}"] = $item_id;
//                                $counter++;
//                            }
//                        }
//                    }
//
//                    // Execute batch insert
//                    if (!empty($values)) {
//                        $insert_sql = "INSERT INTO cus_req_doc_standard_assign
//                          (cus_req_id, cus_req_standard_id, cus_req_standard_item_id)
//                          VALUES " . implode(', ', $values);
//
//                        $command = \Yii::$app->db->createCommand($insert_sql);
//                        foreach ($params as $param => $value) {
//                            $command->bindValue($param, $value);
//                        }
//                        $command->execute();
//                    }
//                }
                // บันทึกข้อมูล products
                if ($product_id != null) {
                    \common\models\CustomerRequestProduct::deleteAll(['customer_req_id' => $model->id]);
                    for ($i = 0; $i <= count($product_id) - 1; $i++) {
                        if ($product_qty[$i] == null) {
                            continue;
                        } else {
                            $model_product = new \common\models\CustomerRequestProduct();
                            $model_product->customer_req_id = $model->id;
                            $model_product->product_id = $product_id[$i];
                            $model_product->qty = $product_qty[$i];
                            $model_product->save(false);
                        }
                    }
                }


                // เตรียมข้อมูลสำหรับ batch insert
                if (!empty($_POST['standard_items'])) {
                    $this->insertStandardAssignments($model->id, $_POST['standard_items'],$model);
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

            $model->market_emp_date = date('Y-m-d', strtotime($m_emp_date));

            if ($model->save(false)) {
                // บันทึกข้อมูล products
                if ($product_id != null) {
                    \common\models\CustomerRequestProduct::deleteAll(['customer_req_id' => $model->id]);
                    for ($i = 0; $i <= count($product_id) - 1; $i++) {
                        if ($product_qty[$i] == null) {
                            continue;
                        } else {
                            $model_product = new \common\models\CustomerRequestProduct();
                            $model_product->customer_req_id = $model->id;
                            $model_product->product_id = $product_id[$i];
                            $model_product->qty = $product_qty[$i];
                            $model_product->save(false);
                        }
                    }
                }



                // เตรียมข้อมูลสำหรับ batch insert
                if (!empty($_POST['standard_items'])) {
                    $this->insertStandardAssignments($model->id, $_POST['standard_items'],$model);
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
     * ลบข้อมูลเก่าทั้งหมด รวมรูปภาพที่เกี่ยวข้อง
     */
    private function deleteOldAssignments($cusReqId)
    {
        // ลบรูปภาพที่เกี่ยวข้องก่อน
        $delete_photo_sql = "DELETE p FROM cus_req_doc_standard_assign_photo p 
                        INNER JOIN cus_req_doc_standard_assign a ON p.cus_req_doc_standard_assign_id = a.id 
                        WHERE a.cus_req_id = :cus_req_id";
        \Yii::$app->db->createCommand($delete_photo_sql)
            ->bindValue(':cus_req_id', $cusReqId)
            ->execute();

        // ลบ assignment records
        $delete_sql = "DELETE FROM cus_req_doc_standard_assign WHERE cus_req_id = :cus_req_id";
        \Yii::$app->db->createCommand($delete_sql)
            ->bindValue(':cus_req_id', $cusReqId)
            ->execute();
    }

    /**
     * บันทึกข้อมูล standard assignments และรูปภาพ
     */
    private function insertStandardAssignments($cusReqId, $standardItems,$model)
    {
        $values = [];
        $params = [];
        $counter = 0;
        $assignmentIds = [];

        // เตรียมข้อมูลสำหรับ batch insert assignments
        foreach ($standardItems as $standard_id => $item_ids) {
            if (!empty($item_ids)) {
                foreach ($item_ids as $item_id) {
                    $values[] = "(:cus_req_id_{$counter}, :standard_id_{$counter}, :item_id_{$counter})";
                    $params[":cus_req_id_{$counter}"] = $cusReqId;
                    $params[":standard_id_{$counter}"] = $standard_id;
                    $params[":item_id_{$counter}"] = $item_id;
                    $counter++;
                }
            }
        }
        // ✅ เพิ่มส่วนตรวจสอบไฟล์แนบก่อนจัดการรูป
        $hasFileUpload = false;
        foreach ($_FILES as $fileGroup) {
            foreach ($fileGroup['name'] as $fileName) {
                if (!empty($fileName)) {
                    $hasFileUpload = true;
                    break 2; // เจอไฟล์จริงออกเลย
                }
            }
        }

        if($hasFileUpload){

            // ลบข้อมูลเก่าทั้งหมด (รวมรูปภาพ)
            // $this->deleteOldAssignments($model->id);
            $delete_sql = "DELETE FROM cus_req_doc_standard_assign WHERE cus_req_id = :cus_req_id";
            \Yii::$app->db->createCommand($delete_sql)
                ->bindValue(':cus_req_id', $model->id)
                ->execute();

            // Execute batch insert assignments
            if (!empty($values)) {
                $insert_sql = "INSERT INTO cus_req_doc_standard_assign 
                      (cus_req_id, cus_req_standard_id, cus_req_standard_item_id) 
                      VALUES " . implode(', ', $values);

                $command = \Yii::$app->db->createCommand($insert_sql);
                foreach ($params as $param => $value) {
                    $command->bindValue($param, $value);
                }
                $command->execute();

                // ดึง IDs ที่เพิ่งบันทึก เพื่อใช้กับการบันทึกรูปภาพ
                $assignmentIds = $this->getNewAssignmentIds($cusReqId, $standardItems);
            }
            // บันทึกรูปภาพ
            $this->handlePhotoUploads($assignmentIds);
            \Yii::$app->session->setFlash('success', 'Assignments successfully uploaded');
        }else{
            \Yii::$app->session->setFlash('error', "Please upload an image file");
        }

    }

    /**
     * ดึง assignment IDs ที่เพิ่งบันทึก
     */
    private function getNewAssignmentIds($cusReqId, $standardItems)
    {
        $assignmentIds = [];

        foreach ($standardItems as $standard_id => $item_ids) {
            if (!empty($item_ids)) {
                foreach ($item_ids as $item_id) {
                    $sql = "SELECT id FROM cus_req_doc_standard_assign 
                       WHERE cus_req_id = :cus_req_id 
                       AND cus_req_standard_id = :standard_id 
                       AND cus_req_standard_item_id = :item_id";

                    $assignmentId = \Yii::$app->db->createCommand($sql)
                        ->bindValue(':cus_req_id', $cusReqId)
                        ->bindValue(':standard_id', $standard_id)
                        ->bindValue(':item_id', $item_id)
                        ->queryScalar();

                    if ($assignmentId) {
                        $key = $standard_id . '_' . $item_id;
                        $assignmentIds[$key] = $assignmentId;
                    }
                }
            }
        }

        return $assignmentIds;
    }

    /**
     * จัดการการอัพโหลดรูปภาพ
     */
    private function handlePhotoUploads($assignmentIds)
    {
        $uploadPath = \Yii::getAlias('@webroot/uploads/customer-request-photos/');

        // สร้าง directory หากไม่มี
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // ตรวจสอบไฟล์ที่อัพโหลด
        if (!empty($_FILES)) {
            foreach ($_FILES as $fieldName => $fileData) {
                // ตรวจสอบว่า field name เป็น pattern ของรูปภาพหรือไม่
                // เช่น photo_1_2, photo_1_3 (standard_id_item_id)
                if (strpos($fieldName, 'photo_') === 0) {
                    $keyPart = str_replace('photo_', '', $fieldName);

                    if (isset($assignmentIds[$keyPart])) {
                        $assignmentId = $assignmentIds[$keyPart];

                        // ตรวจสอบว่ามีไฟล์ที่อัพโหลดมาหรือไม่
                        if (is_array($fileData['name']) && !empty($fileData['name'][0])) {
                            // จัดการไฟล์หลายไฟล์
                            for ($i = 0; $i < count($fileData['name']); $i++) {
                                if (!empty($fileData['name'][$i]) && $fileData['error'][$i] === UPLOAD_ERR_OK) {
                                    $this->savePhotoFile(
                                        $assignmentId,
                                        $fileData['tmp_name'][$i],
                                        $fileData['name'][$i],
                                        $uploadPath
                                    );
                                }
                            }
                        } elseif (!is_array($fileData['name']) && !empty($fileData['name'])) {
                            // ไฟล์เดี่ยว
                            if ($fileData['error'] === UPLOAD_ERR_OK) {
                                $this->savePhotoFile(
                                    $assignmentId,
                                    $fileData['tmp_name'],
                                    $fileData['name'],
                                    $uploadPath
                                );
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * บันทึกไฟล์รูปภาพและข้อมูลลงฐานข้อมูล
     */
    private function savePhotoFile($assignmentId, $tmpName, $originalName, $uploadPath)
    {
        // สร้างชื่อไฟล์ใหม่เพื่อป้องกันการซ้ำ
        $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
        $fileName = 'photo_' . $assignmentId . '_' . time() . '_' . uniqid() . '.' . $fileExtension;
        $fullPath = $uploadPath . $fileName;

        // ย้ายไฟล์
        if (move_uploaded_file($tmpName, $fullPath)) {
            // บันทึกข้อมูลลงฐานข้อมูล
            $insert_photo_sql = "INSERT INTO cus_req_doc_standard_assign_photo 
                           (cus_req_doc_standard_assign_id, photo) 
                           VALUES (:assignment_id, :photo)";

            \Yii::$app->db->createCommand($insert_photo_sql)
                ->bindValue(':assignment_id', $assignmentId)
                ->bindValue(':photo', $fileName)
                ->execute();
        }
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
                $model_check_dup = \backend\models\Customer::find()->where(['name' => $model->company_name,'status'=>1])->count();
                if ($model_check_dup > 0) {
                    \Yii::$app->session->setFlash('error', 'Customer name already exist.');
                    return $this->redirect(['update', 'id' => $id]);
                }else{
                    $model->is_approve = 1; // approve
                    $model->approve_date = date('Y-m-d H:i:s');
                    $model->approve_emp_id = \Yii::$app->user->id;
                    if($model->save(false)){
                        // $this->createCustomer($model->id);
                        //  echo "ok".$model->id;return;

                        $model_customer = new \backend\models\Customer();
                        $model_customer->code = $model_customer::getLastNo(1, 1);
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
                        }else{
                            \Yii::$app->session->setFlash('error', 'Customer created failed.'. $model_customer->getErrors());
                        }
                        \Yii::$app->session->setFlash('success', 'Approve and create customer successfully.');
                    }
                }


            }
        }
        return $this->redirect(['index']);
    }

    public function createCustomer($id){
//        $company_id = 0;
//        $branch_id = 0;
//        if (!empty(\Yii::$app->user->company_id)) {
//            $company_id = \Yii::$app->user->company_id;
//        }
//        if (!empty(\Yii::$app->user->branch_id)) {
//            $branch_id = \Yii::$app->user->branch_id;
//        }

       // $id = \Yii::$app->request->post('request_id');
        if ($id > 0) {
            $model = $this->findModel($id);
            if ($model) {

                $model_check_dup = \backend\models\Customer::find()->where(['name' => $model->company_name])->count();
                if ($model_check_dup > 0) {
                    \Yii::$app->session->setFlash('msg-danger', 'Customer name already exist.');
                    return $this->redirect(['update', 'id' => $id]);
                }


                $model_customer = new \backend\models\Customer();
                $model_customer->code = $model_customer::getLastNo(1, 1);
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
                }else{
                    \Yii::$app->session->setFlash('msg-danger', 'Customer created failed.'. $model_customer->getErrors());
                }
                \Yii::$app->session->setFlash('msg-success', 'Customer created successfully.');
            }
        }
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

    public function actionAddcontractdoc(){
        $contact_file = UploadedFile::getInstanceByName('contract_doc');
        $model_customer_req_id = \Yii::$app->request->post('customer_req_id');

        if($model_customer_req_id){
            $customer_data = \common\models\CustomerRequest::find()->where(['id' => $model_customer_req_id])->one();
            if($customer_data){
                if($contact_file != null){
                    $model = \common\models\Customer::find()->where(['id' => $customer_data->customer_ref_id])->one();
                    if($model){
                        $contact_file_name = 'cus_'.$customer_data->customer_ref_id.'_'.time() . "." . $contact_file->getExtension();
                        $contact_file->saveAs(Yii::getAlias('@backend') . '/web/uploads/files/customers/' . $contact_file_name);
                        $model->contact_file = $contact_file_name;
                        $model->save(false);
                    }


//                    if($old_contact_file != null){
//                        if(file_exists(Yii::getAlias('@backend') . '/web/uploads/files/customers/' . $old_contact_file)){
//                            unlink(Yii::getAlias('@backend') . '/web/uploads/files/customers/' . $old_contact_file);
//                        }
//                    }
                }
            }

        }
        return $this->redirect(['view', 'id' => $model_customer_req_id]);
    }

    public function actionAddshopphoto(){
        $shop_asset_file = UploadedFile::getInstancesByName('shop_asset_file');
        $model_customer_req_id = \Yii::$app->request->post('customer_req_id');
        if($model_customer_req_id){
            $customer_data = \common\models\CustomerRequest::find()->where(['id' => $model_customer_req_id])->one();
            if($customer_data){
                if($shop_asset_file != null){
                    $model = \common\models\Customer::find()->where(['id' => $customer_data->customer_ref_id])->one();
                    if($model){
                        $x=0;
                       foreach ($shop_asset_file as $file){
                           $shop_asset_file_name = 'cus_'.$x.$customer_data->customer_ref_id.'_'.time() . "." . $file->getExtension();
                           $file->saveAs(Yii::getAlias('@backend') . '/web/uploads/files/customers/' . $shop_asset_file_name);

                           $model_asset = new \common\models\CustomerRequestAssetPhoto();
                           $model_asset->customer_req_id = $customer_data->id;
                           $model_asset->photo = $shop_asset_file_name;
                           $model_asset->status = 1;
                           $model_asset->save(false);
                           $x+=1;
                       }
                    }
                }
            }
        }
        return $this->redirect(['view', 'id' => $model_customer_req_id]);
    }

    public function actionDeleteassetphoto(){
        $req_id = \Yii::$app->request->post('req_id');
        $remove_id = \Yii::$app->request->post('remove_id');

        if($remove_id && $req_id){
            $model = \common\models\CustomerRequestAssetPhoto::find()->where(['id' => $remove_id])->one();
            if($model){
                if(file_exists(Yii::getAlias('@backend') . '/web/uploads/files/customers/'.$model->photo)){
                    unlink(Yii::getAlias('@backend') . '/web/uploads/files/customers/'.$model->photo);
                }
                $model->delete();
            }
        }
        return $this->redirect(['update', 'id' => $req_id]);
    }

    public function actionDeletecontactfile(){
        $req_id = \Yii::$app->request->post('req_id');
        $remove_id = \Yii::$app->request->post('remove_id');
        $remove_file_name = \Yii::$app->request->post('remove_file_name');

       // echo Yii::getAlias('@backend') . '/web/uploads/files/customers/'.$remove_file_name;return;
       // if($remove_id && $req_id){
           // $model = \common\models\CustomerRequestAssetPhoto::find()->where(['id' => $remove_id])->one();
           // if($model){
               $model = \backend\models\Customerrequest::find()->where(['id'=>$req_id])->one();
               if($model){
                   $model_cus = \backend\models\Customer::find()->where(['id'=>$model->customer_ref_id])->one();
                   $model_cus->contact_file = '';
                   if($model_cus->save(false)){
                       if(file_exists(Yii::getAlias('@backend') . '/web/uploads/files/customers/'.$remove_file_name)){
                           unlink(Yii::getAlias('@backend') . '/web/uploads/files/customers/'.$remove_file_name);
                       }
                   }
               }

            //    $model->delete();
           // }
//            $filePath = Yii::getAlias('@backend') . '/web/uploads/files/customers/' . $remove_file_name;
//
//            if (file_exists($filePath) && is_file($filePath)) {
//                unlink($filePath);
//            }
      //  }
        return $this->redirect(['update', 'id' => $req_id]);
    }

    /**
     * ลบรูปภาพ (AJAX action)
     */
    public function actionDeletePhoto()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->request->isPost) {
            $photoId = \Yii::$app->request->post('photo_id');

            if ($photoId) {
                // ค้นหารูปภาพ
                $photo = \common\models\CusReqDocStandardAssignPhoto::findOne($photoId);

                if ($photo) {
                    // ลบไฟล์จริง
                    $filePath = \Yii::getAlias('@webroot/uploads/customer-request-photos/' . $photo->photo);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    // ลบข้อมูลจากฐานข้อมูล
                    if ($photo->delete()) {
                        return ['success' => true];
                    }
                }
            }
        }

        return ['success' => false];
    }
}
