<?php

namespace frontend\modules\api\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;


class CarController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['POST'],
                ],
            ],
        ];
    }
    public function actionList()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $req_data = \Yii::$app->request->getBodyParams();
        $car_id = $req_data['car_id'];
        $company_id = $req_data['company_id'];
        $branch_id = $req_data['branch_id'];

        $data = [];
        $status = false;
        if($company_id && $branch_id && $car_id){
            $model = \common\models\QueryCarRoute::find()->where(['company_id'=>$company_id,'branch_id'=>$branch_id])->andFilterWhere(['!=','id',$car_id])->all();
            //$model = \common\models\Car::find()->where(['delivery_route_id'=>$route_id])->all();
            if ($model) {
                $status = true;
                foreach ($model as $value) {
                    array_push($data, [
                        'id' => $value->id,
                        'code' => $value->code,
                        'name' => $value->name,
                        'route_id' => $value->delivery_route_id,
                        'route_name' => $value->route_name
                    ]);
                }
            }
        }

        return ['status' => $status, 'data' => $data];
    }
}
