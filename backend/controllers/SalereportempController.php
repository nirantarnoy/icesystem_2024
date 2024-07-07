<?php

namespace backend\controllers;

use backend\models\SaleorderbyempSearch;
use backend\models\SalereportbyempSearch;
use backend\models\SalereportempSearch;
use \Yii;
use yii\web\Controller;

class SalereportempController extends Controller
{
    public function actionIndex()
    {

        $searchModel = new SaleorderbyempSearch();
//print_r(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //   $dataProvider->query->andFilterWhere(['>','qty',0])->andFilterWhere(['customer_id'=>2247]);
        $dataProvider->query->andFilterWhere(['>', 'qty', 0]);
        $dataProvider->setSort([
            'defaultOrder' => ['employee_id' => SORT_ASC, 'order_date' => SORT_ASC, 'payment_method_id' => SORT_ASC, 'customer_id' => SORT_ASC, 'product_id' => SORT_ASC]
        ]);

        return $this->render('_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEmpcomlist()
    {

        $view_com_date = \Yii::$app->request->post('com_date');
        $view_emp_id = \Yii::$app->request->post('emp_id');
        $searchModel = new SalereportbyempSearch();
//print_r(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //   $dataProvider->query->andFilterWhere(['>','qty',0])->andFilterWhere(['customer_id'=>2247]);
//        $dataProvider->query->andFilterWhere(['>','qty',0]);
//        $dataProvider->setSort([
//            'defaultOrder'=>['emp_id'=>SORT_ASC,'order_date'=>SORT_ASC,'payment_method_id'=>SORT_ASC,'customer_id'=>SORT_ASC,'product_id'=>SORT_ASC]
//        ]);

        return $this->render('empcomlist', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'view_com_date' => $view_com_date,
            'view_emp_id' => $view_emp_id
        ]);
    }

    public function actionEmpcomnew(){
        $view_com_date = \Yii::$app->request->post('com_date');
        $view_emp_id = \Yii::$app->request->post('emp_id');
        $view_route_id = \Yii::$app->request->post('route_id');
//        $searchModel = new SalereportbyempSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('_newcom', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
            'view_com_date' => $view_com_date,
            'view_emp_id' => $view_emp_id,
            'view_route_id'=> $view_route_id,
        ]);
    }

    public function actionExport()
    {
        $type = 'xsl';
        if ($type != '') {

            $contenttype = "";
            $fileName = "";

            if ($type == 'xsl') {
                $contenttype = "application/x-msexcel";
                $fileName = "export_commission.xls";
            }
            if ($type == 'csv') {
                $contenttype = "application/csv";
                $fileName = "export_commission.csv";
            }

            // header('Content-Encoding: UTF-8');
            header("Content-Type: " . $contenttype . " ; name=\"$fileName\" ;charset=utf-8");
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Transfer-Encoding: binary");
            header("Pragma: no-cache");
            header("Expires: 0");

            print "\xEF\xBB\xBF";

            $f_date = null;
            $t_date = null;
            $view_com_date = \Yii::$app->request->post('com_date');
            $view_emp_id = \Yii::$app->request->post('emp_id');

            if($view_com_date != ''){
                $date_data = explode(' - ',$view_com_date);
                $fdate = null;
                $tdate = null;
                if($date_data > 1){
                    $xdate = explode('/',$date_data[0]);
                    if(count($xdate)>1){
                        $fdate = $xdate[2].'-'.$xdate[1].'-'.$xdate[0];
                    }
                    $xdate2 = explode('/',$date_data[1]);
                    if(count($xdate2)>1){
                        $tdate = $xdate2[2].'-'.$xdate2[1].'-'.$xdate2[0];
                    }
                }

                $f_date = date('Y-m-d',strtotime($fdate));
                $t_date = date('Y-m-d',strtotime($tdate));

            }

            //echo $view_com_date;return;

            $model_emp = null;
            $model = \backend\models\Product::find()->all();

            if ($view_emp_id != null) {
                $model_emp = \backend\models\Employee::find()->where(['id' => $view_emp_id])->all();
            } else {
                $model_emp = \backend\models\Employee::find()->all();
            }


            echo '<table class="table table-striped table-bordered">
            <thead>
            <tr style="font-size: 12px;">
                <th width="5%" style="text-align: center" rowspan="2">#</th>
                <th style="text-align: center" rowspan="2">รหัส</th>
                <th rowspan="2">ชื่อ-นามสกุล</th>
                <th style="text-align: right;background-color: #44ab7d;color: white" rowspan="2">เงินสด</th>
                <th style="text-align: right;background-color: #e4606d;color: white" rowspan="2">เงินเชื่อ</th>
                ';
            foreach ($model as $value) {
                echo '<th colspan="2" style="text-align: center">'.$value->code.'</th>';
            }
            echo '<th style="text-align: right;background-color: #258faf;color: white" rowspan="2">Rate Com</th>
                <th style="text-align: right;background-color: #258faf;color: white" rowspan="2">คอมมิชชั่น</th>
                <th style="text-align: right;background-color: #258faf;color: white" >เงินพิเศษ</th>
            </tr>';
            echo '<tr style="font-size: 12px;">';

            foreach ($model as $value) {
                echo '  <th>จำนวน</th>
                    <th style="background-color: #B4B9BE">ยอดเงิน</th>';
            }
            echo '<th style="text-align: right;background-color: #258faf;color: white">>3,500</th>
            </tr>
            </thead>
            <tbody>';
            $i = 0;
            foreach ($model_emp as $value) {
                $i += 1;
                $line_com = 0;
                $line_amt = 0;
                $line_sum_qty = 0;
                $line_sum_amt = 0;
                echo '<tr style="font-size: 12px;">
                    <td style="text-align: center">' . $i . '</td>
                    <td style="text-align: center">' . $value->code . '</td>
                    <td>' . $value->fname . ' ' . $value->lname . '</td>
                    <td style="text-align: right;background-color: #44ab7d;color: white">' . $this->findCash($value->id, $f_date, $t_date) . '</td>
                    <td style="text-align: right;background-color: #e4606d;color: white">' . $this->findCredit($value->id, $f_date, $t_date) . '</td>';
                foreach ($model as $value2) {
                    $line_qty = $this->findProductqty($value->id, $value2->id, $f_date, $t_date);
                    $line_amt = $this->findProduct($value->id, $value2->id, $f_date, $t_date);
                    $line_sum_qty = $line_sum_qty + $line_qty;
                    $line_sum_amt = $line_sum_amt + $line_amt;
                    $line_com_rate = $this->findComrate($value->id);
                    echo '<td style="text-align: right">'.$line_qty.'</td>';
                    echo '<td style="text-align: right;background-color: #B4B9BE">'.$line_amt.'</td>';
                }
                echo '<td style="text-align: right;background-color: #258faf;color: white">'.$line_com_rate.'</td>
                    <td style="text-align: right;background-color: #258faf;color: white">'. $line_sum_qty * $line_com_rate.'</td>
                    <td style="text-align: right;background-color: #258faf;color: white">'. $this->findComextrarate($value->id, $line_sum_amt).'</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        }
    }
    public function findCash($emp_id, $f_date, $t_date)
    {
        $c = 0;
        if ($emp_id) {
            $model = \common\models\QuerySaleTransByEmp::find()->where(['payment_method_id' => 1, 'emp_id' => $emp_id])->andFilterWhere(['between','order_date',$f_date,$t_date])->sum('qty * price');
            if ($model) {
                $c = $model;
            }
        }
        return $c;
    }

    public function findCredit($emp_id, $f_date, $t_date)
    {
        $c = 0;
        if ($emp_id) {
            $model = \common\models\QuerySaleTransByEmp::find()->where(['payment_method_id' => 2, 'emp_id' => $emp_id])->andFilterWhere(['between','order_date',$f_date,$t_date])->sum('qty * price');
            if ($model) {
                $c = $model;
            }
        }
        return $c;
    }

    public function findProduct($emp_id, $product_id, $f_date, $t_date)
    {
        $c = 0;
        if ($emp_id && $product_id) {
            $model = \common\models\QuerySaleTransByEmp::find()->where(['product_id' => $product_id, 'emp_id' => $emp_id])->andFilterWhere(['between','order_date',$f_date,$t_date])->sum('qty * price');
            if ($model) {
                $c = $model;
            }
        }
        return $c;
    }

    public function findProductqty($emp_id, $product_id, $f_date, $t_date)
    {
        $c = 0;
        if ($emp_id && $product_id) {
            $model = \common\models\QuerySaleTransByEmp::find()->where(['product_id' => $product_id, 'emp_id' => $emp_id])->andFilterWhere(['between','order_date',$f_date,$t_date])->sum('qty');
            if ($model) {
                $c = $model;
            }
        }
        return $c;
    }

    public function findComrate($emp_id)
    {
        $c = 0;
        if ($emp_id) {
            $model = \common\models\CarEmp::find()->where(['emp_id' => $emp_id])->one();
            if ($model) {
                if ($model->car_id) {
                    $sql = "SELECT sale_com.com_extra,sale_com.emp_qty FROM car INNER JOIN sale_com ON car.sale_com_id=sale_com.id WHERE car.id=" . $model->car_id;
                    $query = \Yii::$app->db->createCommand($sql)->queryAll();
                    if ($query != null) {
                        //print_r($query);return;
                        // foreach ($query as $value){
                        $emp_count = $this->findCarempcount($model->car_id);
                        if ($emp_count == $query[0]['emp_qty']) {
                            $c = $query[0]['com_extra'];
                        } else {
                            $c = 0.75;
                        }

                        // }

                    }
                }
            } else {
//            $c= 33;
            }
        }
        return $c;
    }
    public function findComextrarate($emp_id, $sale_total_amt)
    {
        $c = 0;
        if ($emp_id) {
            $model = \common\models\CarEmp::find()->where(['emp_id' => $emp_id])->one();
            if ($model) {
                if ($model->car_id) {
                    $sql = "SELECT sale_com_summary.com_extra,sale_com_summary.sale_price FROM car INNER JOIN sale_com_summary ON car.sale_com_extra=sale_com_summary.id WHERE car.id=" . $model->car_id;
                    $query = \Yii::$app->db->createCommand($sql)->queryAll();
                    if ($query != null) {
                        if($sale_total_amt > $query[0]['sale_price']){
                            $c = $query[0]['com_extra'];
                        }else{
                            $c = 0;
                        }

                    }
                }
            } else {
//            $c= 33;
            }
        }
        return $c;
    }

    public function findCarempcount($car_id)
    {
        $c = 0;
        if ($car_id) {
            $model = \common\models\CarEmp::find()->where(['car_id' => $car_id])->count('emp_id');
            $c = $model;
        }
        return $c;
    }
}
