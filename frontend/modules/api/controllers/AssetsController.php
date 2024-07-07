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


}
