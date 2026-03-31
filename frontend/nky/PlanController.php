<?php

namespace backend\controllers;

use backend\models\PlansummarySearch;
use backend\models\RoutesummarySearch;
use Yii;
use backend\models\Plan;
use backend\models\PlanSearch;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * PlanController implements the CRUD actions for Plan model.
 */
class PlanController extends Controller
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
                            if(Yii::$app->user->can($currentRoute)){
                                return true;
                            }
                        }
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Plan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new PlanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Plan model.
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

    public function actionCreate()
    {
        $company_id = 1;
        $branch_id = 1;
        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }
        $model = new Plan();

        if ($model->load(Yii::$app->request->post())) {
            $product_id = \Yii::$app->request->post('line_prod_id');
            $qty = \Yii::$app->request->post('line_qty');
            $removelist = \Yii::$app->request->post('removelist');


            $x_date = explode('/', $model->trans_date);
            $sale_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $model->trans_date = date('Y-m-d H:i:s', strtotime($sale_date . ' ' . date('H:i:s')));
            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            $model->status = 1;
            $model->journal_no = $model->getLastNo(date('Y-m-d'), $company_id, $branch_id);
            if ($model->save()) {
                if ($product_id != null) {
                    for ($i = 0; $i <= count($product_id) - 1; $i++) {
                        if ($product_id[$i] == null || $product_id == '') continue;
                        $model_line = new \backend\models\Planline();
                        $model_line->plan_id = $model->id;
                        $model_line->product_id = $product_id[$i];
                        $model_line->qty = $qty[$i];
                        $model_line->status = 1;
                        $model_line->save();
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Plan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_line = \backend\models\Planline::find()->where(['plan_id' => $id])->all();

        if ($model->load(Yii::$app->request->post())) {
            $product_id = \Yii::$app->request->post('line_prod_id');
            $qty = \Yii::$app->request->post('line_qty');
            $removelist = \Yii::$app->request->post('removelist');

            $x_date = explode('/', $model->trans_date);
            $sale_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $model->trans_date = date('Y-m-d H:i:s', strtotime($sale_date . ' ' . date('H:i:s')));

            if ($model->save()) {
                if ($product_id != null) {
                    for ($i = 0; $i <= count($product_id) - 1; $i++) {
                        if ($product_id[$i] == null || $product_id == '') continue;

                        $model_check = \backend\models\Planline::find()->where(['plan_id' => $id, 'product_id' => $product_id[$i]])->one();
                        if ($model_check) {
                            $model_check->qty = $qty[$i];
                            $model_check->save();
                        } else {
                            $model_line = new \backend\models\Planline();
                            $model_line->plan_id = $model->id;
                            $model_line->product_id = $product_id[$i];
                            $model_line->qty = $qty[$i];
                            $model_line->status = 1;
                            $model_line->save();
                        }

                    }
                }
                if ($removelist != '') {
                    $x = explode(',', $removelist);
                    if (count($x) > 0) {
                        for ($m = 0; $m <= count($x) - 1; $m++) {
                            \backend\models\Planline::deleteAll(['id' => $x[$m]]);
                        }
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'model_line' => $model_line,
        ]);
    }


    public function actionDelete($id)
    {
        \backend\models\Planline::deleteAll(['plan_id' => $id]);
        if (\backend\models\Plan::deleteAll(['id' => $id])) {
            $issue_id = \backend\models\Journalissue::find()->where(['plan_id' => $id])->one();
            if ($issue_id) {
                \backend\models\Journalissueline::deleteAll(['issue_id' => $issue_id->id]);
                \backend\models\Journalissue::deleteAll(['plan_id' => $id]);
            }
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Plan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCalsummary()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new PlansummarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->groupby(['code']);
        $dataProvider->setSort(['defaultOrder' => ['code' => SORT_DESC]]);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('plansummary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    public function actionRoutesummary()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new RoutesummarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['route_id' => SORT_ASC]]);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('routesummary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    public function actionReservorder($id)
    {
        if ($id) {
            $company_id = 1;
            $branch_id = 1;
            if (!empty(\Yii::$app->user->identity->company_id)) {
                $company_id = \Yii::$app->user->identity->company_id;
            }
            if (!empty(\Yii::$app->user->identity->branch_id)) {
                $branch_id = \Yii::$app->user->identity->branch_id;
            }

            $model = \common\models\PlanLine::find()->where(['plan_id' => $id])->all();
            if ($model) {
                $model_reserv = new \backend\models\Orderreserv();
                $model_reserv->journal_no = $model_reserv::getLastNo($company_id, $branch_id);
                $model_reserv->status = 1;
                $model_reserv->company_id = $company_id;
                $model_reserv->branch_id = $branch_id;

                if ($model_reserv->save(false)) {
                    foreach ($model as $value) {
                        $model_reserv_line = new \common\models\OrderReservLine();
                        $model_reserv_line->reserv_id = $model_reserv->id;
                        $model_reserv_line->product_id = $value->product_id;
                        $model_reserv_line->qty = $value->qty;
                        $model_reserv_line->status = 1;
                        $model_reserv_line->save(false);
                    }
                }

            }
        }
    }

    public function actionPlanreview(){
        $company_id = 0;
        $branch_id = 0;

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }

        $from_date = \Yii::$app->request->post('from_date');
       // $to_date = \Yii::$app->request->post('to_date');
        $find_route_id = \Yii::$app->request->post('find_route_id');
        return $this->render('_planoverview',[
            'from_date' => $from_date,
          //  'to_date' => $to_date,
            //    'find_sale_type'=>$find_sale_type,
            'find_route_id' => $find_route_id,
            'company_id' => $company_id,
            'branch_id' => $branch_id,
        ]);
    }

    public function actionProductionplan()
    {
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

        if ($from_date == null) {
            $from_date = date('d-m-Y');
        }
        if ($to_date == null) {
            $to_date = date('d-m-Y');
        }

        return $this->render('_production_plan', [
            'from_date' => $from_date,
            'to_date' => $to_date,
            'company_id' => $company_id,
            'branch_id' => $branch_id,
        ]);
    }

    public function actionExportproductionplan()
    {
        @set_time_limit(0);
        @ini_set('memory_limit', '512M');

        $company_id = 0;
        $branch_id = 0;

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }

        $from_date = \Yii::$app->request->get('from_date');
        $to_date = \Yii::$app->request->get('to_date');
        $view_type = \Yii::$app->request->get('view_type', 1);

        if ($from_date == null) {
            $from_date = date('Y-m-d');
        } else {
            $from_date = date('Y-m-d', strtotime($from_date));
        }
        if ($to_date == null) {
            $to_date = date('Y-m-d');
        } else {
            $to_date = date('Y-m-d', strtotime($to_date));
        }

        $join_type = ($view_type == 2) ? "INNER JOIN" : "LEFT JOIN";

        $sql = "SELECT t1.id as route_id, t1.name as route_name, t1.is_two_rap, t1.prod_show_seq,
               t2.id as plan_id, t2.car_name, t2.fname, t2.lname, t2.code, t2.qty, t2.trans_date, t2.name as product_name
        FROM delivery_route t1
        $join_type query_plan_by_route t2 ON t1.id = t2.route_id 
             AND date(t2.trans_date2) >= :from_date 
             AND date(t2.trans_date2) <= :to_date
        WHERE (t1.status = 1 OR t1.status IS NULL)
        AND t1.prod_show_seq > 0";

        $params = [':from_date' => $from_date, ':to_date' => $to_date];
        if ($company_id > 0) {
            $sql .= " AND t1.company_id = :company_id";
            $params[':company_id'] = $company_id;
        }
        if ($branch_id > 0) {
            $sql .= " AND t1.branch_id = :branch_id";
            $params[':branch_id'] = $branch_id;
        }
        $sql .= " ORDER BY IFNULL(t1.prod_show_seq, 999999) ASC, t1.name ASC, t2.trans_date ASC, t2.code ASC";

        $data = Yii::$app->db->createCommand($sql, $params)->queryAll();

        $routes = [];
        $product_codes = [];
        $preferred_order = ['PB', 'PS', 'PC', 'Mแดง', 'Mม่วง', 'M', 'M_DUP', 'R', 'K', 'P2'];
        $last_items = ['B', 'S'];

        foreach ($data as $row) {
            $route_name = $row['route_name'];
            $is_two_rap = $row['is_two_rap'];
            $plan_id = $row['plan_id'];
            $product_code = $row['code'];

            if (!isset($routes[$route_name])) {
                $routes[$route_name] = [
                    'route_name' => $route_name,
                    'car_name' => '', 'driver_name' => '',
                    'is_two_rap' => $is_two_rap, 'plans' => []
                ];
            }

            if ($plan_id) {
                // Identify plan key first
                $plan_key = ($is_two_rap == 1) ? $plan_id : 'single';

                // Handle duplicate M entries per plan
                $final_product_code = $product_code;
                if ($product_code == 'M') {
                    if ($route_name == 'VP31') {
                        $final_product_code = 'M_DUP';
                    } else if (isset($routes[$route_name]['plans'][$plan_key]['products']['M'])) {
                        $final_product_code = 'M_DUP';
                    }
                }

                if (!empty($final_product_code) && !in_array($final_product_code, $product_codes)) {
                    $product_codes[] = $final_product_code;
                }
                if (empty($routes[$route_name]['car_name'])) $routes[$route_name]['car_name'] = $row['car_name'];
                if (empty($routes[$route_name]['driver_name'])) $routes[$route_name]['driver_name'] = trim(($row['fname'] ?? '') . ' ' . ($row['lname'] ?? ''));

                if (!isset($routes[$route_name]['plans'][$plan_key])) {
                    $routes[$route_name]['plans'][$plan_key] = [
                        'full_time' => $row['trans_date'], // for sorting
                        'products' => []
                    ];
                }
                if (!empty($final_product_code)) {
                    $routes[$route_name]['plans'][$plan_key]['products'][$final_product_code] = ($routes[$route_name]['plans'][$plan_key]['products'][$final_product_code] ?? 0) + $row['qty'];
                }
            }
        }

        // Sort plans for each route by time
        foreach ($routes as &$r) {
            if (!empty($r['plans'])) {
                uasort($r['plans'], function($a, $b) {
                    $ta = !empty($a['full_time']) ? strtotime($a['full_time']) : 0;
                    $tb = !empty($b['full_time']) ? strtotime($b['full_time']) : 0;
                    return $ta - $tb;
                });
            }
        }
        unset($r);

        usort($product_codes, function($a, $b) use ($preferred_order, $last_items) {
            if (in_array($a, $last_items) && in_array($b, $last_items)) return array_search($a, $last_items) - array_search($b, $last_items);
            if (in_array($a, $last_items)) return 1;
            if (in_array($b, $last_items)) return -1;
            $pos_a = array_search($a, $preferred_order); $pos_b = array_search($b, $preferred_order);
            if ($pos_a === false && $pos_b === false) return strcmp($a, $b);
            if ($pos_a === false) return 1;
            if ($pos_b === false) return -1;
            return $pos_a - $pos_b;
        });

        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        ob_start();

        echo "\xEF\xBB\xBF"; // UTF-8 BOM

        echo '<table border="1">
            <thead>
                <tr>
                    <td colspan="' . (count($product_codes) + 8) . '" style="text-align: center; font-weight: bold; font-size: 14pt; border: none;">รายการเบิกของประจำวัน (Production Plan)</td>
                </tr>
                <tr>
                    <td colspan="' . (count($product_codes) + 8) . '" style="text-align: center; border: none;">วันที่: ' . date('d/m/Y', strtotime($from_date)) . ($from_date != $to_date ? ' ถึง ' . date('d/m/Y', strtotime($to_date)) : '') . '</td>
                </tr>
                <tr><td colspan="' . (count($product_codes) + 8) . '" style="border: none;">&nbsp;</td></tr>
                <tr>
                    <th style="background-color: #cccccc;">ลำดับ</th>
                    <th style="background-color: #cccccc;">เวลา</th>
                    <th style="background-color: #cccccc;">สาย</th>
                    <th style="background-color: #cccccc;">ทะเบียน</th>
                    <th style="background-color: #cccccc;">พนักงานขับรถ</th>
                    <th style="background-color: #cccccc;">แผน/รอบ</th>';
        foreach ($product_codes as $code) { 
            $display_label = ($code == 'M_DUP') ? 'M' : $code;
            echo '<th style="background-color: #cccccc;">' . $display_label . '</th>'; 
        }
        echo '<th style="background-color: #cccccc;">รวม</th>
              <th style="background-color: #cccccc;">หมายเหตุ</th>
            </tr>
            </thead>
            <tbody>';

        $main_idx = 1;
        $grand_total_products = array_fill_keys($product_codes, 0);
        $grand_total_all = 0;

        foreach ($routes as $route_data) {
            $is_two_rap = $route_data['is_two_rap'] ?? 0;
            $display_rows = ($is_two_rap == 1) ? 2 : 1;
            $raw_plans = array_values($route_data['plans']);

            for ($row_idx = 0; $row_idx < $display_rows; $row_idx++) {
                $plan_info = $raw_plans[$row_idx] ?? null;
                $plan_total = 0;
                echo '<tr>';
                if ($row_idx == 0) {
                    echo '<td rowspan="'.$display_rows.'" style="text-align: center; vertical-align: middle;">'.$main_idx++.'</td>';
                    echo '<td rowspan="'.$display_rows.'" style="vertical-align: middle;"></td>';
                    echo '<td rowspan="'.$display_rows.'" style="vertical-align: middle;">'.$route_data['route_name'].'</td>';
                    echo '<td rowspan="'.$display_rows.'" style="vertical-align: middle;">'.$route_data['car_name'].'</td>';
                    echo '<td rowspan="'.$display_rows.'" style="text-align: left; vertical-align: middle; padding-left: 5px;">'.$route_data['driver_name'].'</td>';
                }
                echo '<td style="background-color: #fff8e1;">'.($is_two_rap == 1 ? "รอบที่ ".($row_idx+1) : '').'</td>';
                foreach ($product_codes as $code) {
                    $qty = 0;
                    if ($plan_info && isset($plan_info['products'][$code])) {
                        $qty = $plan_info['products'][$code];
                    }
                    $plan_total += $qty;
                    $grand_total_products[$code] += $qty;
                    echo '<td style="text-align: right;">'.($qty > 0 ? number_format($qty) : '').'</td>';
                }
                echo '<td style="background-color: #f2f2f2; text-align: right; font-weight: bold;">'.($plan_total > 0 ? number_format($plan_total) : '').'</td>';
                echo '<td></td></tr>';
                $grand_total_all += $plan_total;
            }
        }
        echo '<tr style="background-color: #ffeb3b; font-weight: bold;"><td colspan="6" style="text-align: right;">รวมทั้งสิ้น</td>';
        foreach ($product_codes as $code) { echo '<td style="text-align: right;">'.number_format($grand_total_products[$code]).'</td>'; }
        echo '<td style="text-align: right; background-color: #ffc107;">'.number_format($grand_total_all).'</td><td></td></tr>';
        
        // Additional Footer Rows
        echo '<tr style="font-weight: bold;">
                <td colspan="4" style="text-align: left;">PB เซทละ 190 แพ็ค</td>
                <td colspan="2" style="text-align: right;">ยอดคงเหลือ</td>';
        foreach ($product_codes as $code) { echo '<td></td>'; }
        echo '<td></td><td></td></tr>';

        echo '<tr style="font-weight: bold;">
                <td colspan="4" style="text-align: left;">PS เซทละ 95 แพ็ค</td>
                <td colspan="2" style="text-align: right;">ยอดผลิตจริง</td>';
        foreach ($product_codes as $code) { echo '<td></td>'; }
        echo '<td></td><td></td></tr>';
   echo '<tr style="font-weight: bold;">
                <td colspan="4" style="text-align: left;">PS เซทละ 1200 แพ็ค</td>
                <td colspan="2" style="text-align: right;">-/+</td>';
        foreach ($product_codes as $code) { echo '<td></td>'; }
        echo '<td></td><td></td></tr>';

        echo '</tbody></table>';

        // Signature Section
        echo '<br><br>';
        echo '<table style="width: 100%; border: none;">
                <tr>
                    <td colspan="' . (floor((count($product_codes) + 8) / 3)) . '" style="text-align: center; border: none;">
                        <div>ผู้บันทึกเบิก .................................</div>
                        <div style="font-weight: bold;">( ธุรการ )</div>
                    </td>
                    <td colspan="' . (floor((count($product_codes) + 8) / 3)) . '" style="text-align: center; border: none;">
                        <div>ผู้บันทึกยอดยกมา ...................................</div>
                        <div style="font-weight: bold;">( เสมียนกะบ่าย )</div>
                    </td>
                    <td colspan="' . (count($product_codes) + 8 - (2 * floor((count($product_codes) + 8) / 3))) . '" style="text-align: center; border: none;">
                        <div>ผู้บันทึกยอดผลิตจริง ................................</div>
                        <div style="font-weight: bold;">( เสมียนกะดึก/เช้า )</div>
                    </td>
                </tr>
              </table>';
        
        $content = ob_get_clean();

        $fileName = "production_plan_" . date('YmdHis') . ".xls";
        header("Content-Type: application/octet-stream; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo $content;
        exit();
    }
}
