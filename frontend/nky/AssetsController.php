<?php

namespace frontend\modules\api\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;


class AssetsController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['POST'],
                    'checklist' => ['POST'],
                    'createmarketsession' => ['POST'],
                ],
            ],
        ];
    }
    public function actionList()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $customer_id = $req_data['customer_id'];
        $company_id = $req_data['company_id'];
        $branch_id = $req_data['branch_id'];

        $data = [];
        $status = false;
        if($company_id && $branch_id && $customer_id){
            $model = \common\models\CustomerAsset::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id,'customer_id'=>$customer_id])->all();
            //$model = \common\models\Car::find()->where(['delivery_route_id'=>$route_id])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    $asset_data = $this->getAssetData($value->product_id);
                    $code = '';
                    $name = '';
                    if($asset_data){
                        $code = $asset_data[0]['code'];
                        $name = $asset_data[0]['name'];
                    }
                    array_push($data, [
                        'id' => $value->id,
                        'code' => $code,
                        'name' => $name,
                        'photo' => '',
                    ]);
                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }
    public function getAssetData($id){
        $data = [];
        if($id){
            $model = \common\models\Assets::find()->where(['id'=>$id])->one();
            if($model){
                array_push($data,['code'=>$model->asset_no,'name'=>$model->asset_name]);
            }
        }
        return $data;
    }

    public function actionCreatemarketsession()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();

        $status = false;
        $transaction = \Yii::$app->db->beginTransaction();
        $user_id = isset($req_data['user_id']) ? $req_data['user_id'] : 1;
        $company_id = isset($req_data['company_id']) ? $req_data['company_id'] : 1;
        $branch_id = isset($req_data['branch_id']) ? $req_data['branch_id'] : 1;
        try {
            if ($req_data != null) {
                // 1. บันทึก Session
                $model_session = new \backend\models\MarketingSession();
                $model_session->attributes = $req_data; // หรือ map ทีละฟิลด์ตามตัวอย่างก่อนหน้า
                $model_session->customer_id = $req_data['customer_id'];
                $model_session->customer_name = $req_data['customer_name'];
                $model_session->user_id = $user_id;
                $model_session->company_id = $company_id;
                $model_session->branch_id = $branch_id;
                $model_session->check_in_lat = $req_data['check_in_lat'];
                $model_session->check_in_long = $req_data['check_in_long'];
                $model_session->check_out_lat = $req_data['check_out_lat'];
                $model_session->check_out_long = $req_data['check_out_long'];

                // แปลงเวลาจาก ISO8601 เป็น MySQL Format
                if (!empty($req_data['check_in_time'])) {
                    $model_session->check_in_time = date('Y-m-d H:i:s', strtotime($req_data['check_in_time']));
                }
                if (!empty($req_data['check_out_time'])) {
                    $model_session->check_out_time = date('Y-m-d H:i:s', strtotime($req_data['check_out_time']));
                }

                if ($model_session->save(false)) {
                    foreach ($req_data['activities'] as $act) {
                        // 2. บันทึก Activity
                        $model_act = new \backend\models\MarketingActivity();
                        $model_act->session_id = $model_session->id;
                        $model_act->activity_type = $act['title'];
                        $model_act->route_id = $act['route_id'];
                        $model_act->route_name = $act['route_name'];
                        $model_act->shop_name = $act['shop_name']; // เปลี่ยนจาก shopName เป็น shop_name
                        $model_act->activity_check_in_time = $act['check_in_time']; // เปลี่ยนจาก checkInTime เป็น check_in_time
                        $model_act->activity_check_out_time = $act['check_out_time']; // เปลี่ยนจาก checkOutTime เป็น check_out_time
                        $model_act->start_time = $act['start_time']; // เปลี่ยนจาก startTime เป็น start_time
                        $model_act->end_time = $act['end_time']; // เปลี่ยนจาก endTime เป็น end_time
                        $model_act->event_detail = $act['event_detail']; // เปลี่ยนจาก eventDetail เป็น event_detail
                        $model_act->rent_borrow_tank = $act['rent_borrow_tank']; // เปลี่ยนจาก rentBorrowTank เป็น rent_borrow_tank
                        $model_act->collect_tank = $act['collect_tank']; // เปลี่ยนจาก collectTank เป็น collect_tank

                        if ($model_act->save(false)) {
                            // 3. จัดการรูปภาพ Base64
                            if (isset($act['photos']) && is_array($act['photos'])) {
                                foreach ($act['photos'] as $index => $base64_str) {
                                    if (!empty($base64_str)) {
                                        // แปลง Base64 เป็นไฟล์
                                        $image_data = base64_decode($base64_str);
                                        $file_name = 'mkt_' . time() . '_' . $model_act->id . '_' . $index . '.jpg';
                                        $upload_path = \Yii::getAlias('@backend/web/uploads/marketing/') . $file_name;

                                        if (file_put_contents($upload_path, $image_data)) {
                                            $model_photo = new \backend\models\MarketingActivityPhoto();
                                            $model_photo->activity_id = $model_act->id;
                                            $model_photo->photo_path = $file_name;
                                            $model_photo->save(false);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $status = true;
                    $transaction->commit();
                }
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            $status = false;
        }

        return ['status' => $status];
    }


}
