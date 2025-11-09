<?php

namespace backend\controllers;

use backend\models\SalereportSearch;
use \Yii;
use backend\models\SalecomSearch;
use yii\web\Controller;

class SaleroutesummaryController extends Controller{
    public $enableCsrfValidation =false;

    public function actionIndex(){

        $company_id = 0;
        $branch_id = 0;

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }
        $from_date = \Yii::$app->request->post('from_date');
        $to_date = \Yii::$app->request->post('to_date');
        $find_route_id = \Yii::$app->request->post('find_route');
        return $this->render('_print', [
            'from_date' => $from_date,
            'to_date' => $to_date,
            'company_id' => $company_id,
            'branch_id' => $branch_id,
            'find_route' => $find_route_id
        ]);
    }

}
?>
