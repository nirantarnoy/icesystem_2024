<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class CheckrouteController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new ForbiddenHttpException('คุณไม่ได้รับอนุญาติให้เข้าใช้งาน!');
                },
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
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

    public function actionIndex()
    {
        $route_id = \Yii::$app->request->get('route_id');
        $view_type = \Yii::$app->request->get('view_type', 'list');
        $all_routes = \backend\models\Deliveryroute::find()->where(['status' => 1])->all();

        $data = [];
        if ($route_id) {
            $customers = \backend\models\Customer::find()
                ->where(['delivery_route_id' => $route_id, 'status' => 1])
                ->orderBy(['route_num' => SORT_ASC])
                ->all();

            foreach ($customers as $cust) {
                $data[] = [
                    'id' => $cust->id,
                    'code' => $cust->code,
                    'name' => $cust->name,
                    'route_num' => $cust->route_num,
                    'location_info' => $cust->location_info,
                    'status' => $cust->status,
                ];
            }
        }

        return $this->render('index', [
            'data' => $data,
            'all_routes' => $all_routes,
            'route_id' => $route_id,
            'view_type' => $view_type,
        ]);
    }
}
