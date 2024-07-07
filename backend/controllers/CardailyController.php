<?php

namespace backend\controllers;

use backend\models\StreamAssignSearch;
use Yii;
use backend\models\Cardaily;
use backend\models\CardailySearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class CardailyController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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

    /**
     * Lists all Cardaily models.
     * @return mixed
     */
    public function actionIndex()
    {
        // print_r(Yii::$app->request->queryParams);return;

        $company_id = 1;
        $branch_id = 1;

        if (\Yii::$app->user->identity->company_id != null) {
            $company_id = \Yii::$app->user->identity->company_id;
        } else {
            return $this->redirect(['site/logout']);
        }
        if (\Yii::$app->user->identity->branch_id != null) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }
//        if (isset($_SESSION['user_company_id'])) {
//            $company_id = $_SESSION['user_company_id'];
//        }
//        if (isset($_SESSION['user_branch_id'])) {
//            $branch_id = $_SESSION['user_branch_id'];
//        }

        $save_emp_date = null;
        $save_emp_route = null;

        if (!empty(\Yii::$app->request->queryParams[1]['trans_date'])) {
            // print_r(\Yii::$app->request->get());return;
            //  echo "has data";return;
            $save_emp_date = date('Y-m-d', strtotime(\Yii::$app->request->queryParams[1]['trans_date']));
            //echo $save_emp_date;return;
        }
        if (!empty(\Yii::$app->request->queryParams[1]['route_id'])) {
            $save_emp_route = \Yii::$app->request->get('route_id');
        }
        //print_r(Yii::$app->request->queryParams[1]['route_id']);return;
        $route_type_id = null;
        $car_name = null;
        if (isset(Yii::$app->request->queryParams['CardailySearch'])) {
            $route_type_id = Yii::$app->request->queryParams['CardailySearch']['route_id'];
        }
        if (isset(Yii::$app->request->queryParams['CardailySearch'])) {
            $car_name = Yii::$app->request->queryParams['CardailySearch']['car_name'];
        }
        $car_search_text = \Yii::$app->request->post('car_name');

        $searchModel = new CardailySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // if (isset($_SESSION['user_company_id'])) {
        $dataProvider->query->andFilterWhere(['car_daily.company_id' => $company_id]);
        //  }
        // if (isset($_SESSION['user_branch_id'])) {
        $dataProvider->query->andFilterWhere(['car_daily.branch_id' => $branch_id]);
        // }

        if ($save_emp_route != null) {
            $searchModel->route_id = $save_emp_route;
            $dataProvider->query->andFilterWhere(['delivery_route_id' => $save_emp_route]);
        }
//        if ($save_emp_date != null) {
////            $x_date = explode('-', $save_emp_date);
////            $f_date = date('Y-m-d');
////            if (count($x_date) > 1) {
////                $f_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
////            }
//            $trans_date = date('Y-m-d', strtotime($save_emp_date));
//            //echo $trans_date;return;
//            $searchModel->trans_date = $trans_date;
//            $dataProvider->query->andFilterWhere(['date(car_daily.trans_date)' => $trans_date])->all();
//        }

        $dataProvider->pagination->pageSize = 100;

        //echo $dataProvider->

        //  echo $route_type_id;return;
        $query = \common\models\QueryCarRoute::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->orderBy(['route_code'=>SORT_ASC]);
        if ($route_type_id != null) {
            $query = $query->andFilterWhere(['delivery_route_id' => $route_type_id]);
        }
        if ($car_name != null) {
            $query = $query->andFilterWhere(['OR', ['LIKE', 'name', $car_name], ['LIKE', 'code', $car_name]]);
        }

        // after save emp

        $model_car = $query->all();

        return $this->render('_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model_car' => $model_car
        ]);
//        $searchModel = new CardailySearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider->pagination->pageSize = 1000;
        // $model = \backend\models\Cardaily::find()->all();

        // print_r($model);return;

//        return $this->render('_index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Cardaily();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cardaily model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cardaily model.
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
     * Finds the Cardaily model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cardaily the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cardaily::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAddemp()
    {
        $t_date = null;
        $route_id = 0;
        $car_id = \Yii::$app->request->post('selected_car');
        $route_id = \Yii::$app->request->post('route_id');
        $t_date = \Yii::$app->request->post('selected_date');
        $emp_id = \Yii::$app->request->post('line_car_emp_id');
        $isdriver = \Yii::$app->request->post('line_car_driver');

        $company_id = 1;
        $branch_id = 1;

        if (\Yii::$app->user->identity->company_id != null) {
            $company_id = \Yii::$app->user->identity->company_id;
        } else {
            return $this->redirect(['site/logout']);
        }
        if (\Yii::$app->user->identity->branch_id != null) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }

//        print_r(\Yii::$app->request->post());
//        echo count($emp_id);
//        return;

        if ($route_id == null || $route_id == '') {
            $route_id = 0;
        }

        if ($t_date == null) {
            $t_date = date('Y-m-d');
        } else {
            $x_date = explode('/', $t_date);
            $x_date2 = null;
            if (count($x_date) > 1) {
                $x_date2 = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $t_date = date('Y-m-d', strtotime($x_date2));
        }
//        print_r($car_id);
//        echo count($emp_id);return;
        if ($car_id) {
            if ($emp_id != null) {
                for ($i = 0; $i <= count($emp_id) - 1; $i++) {
                    if ($emp_id[$i] == '') continue; // $emp_id[$i] = 0;
                    if ($this->checkOld($emp_id[$i], $car_id, $t_date,$company_id,$branch_id)) {
                         //echo "has no ";return;
                        $model = \backend\models\Cardaily::find()->where(['employee_id' => $emp_id, 'date(trans_date)' => $t_date, 'employee_id' => $emp_id[$i], 'car_id' => $car_id])->one();
                        if ($model) {
                            $model->is_driver = $isdriver[$i] == 1 ? 1 : 0;
                            $model->save(false);
                        } else {
                            $model = new \backend\models\Cardaily();
                            $model->car_id = $car_id;
                            $model->employee_id = $emp_id[$i];
                            $model->trans_date = $t_date;
                            $model->is_driver = $isdriver[$i] == 1 ? 1 : 0;
                            $model->status = 1;
                            $model->company_id = $company_id;
                            $model->branch_id = $branch_id;
                            $model->save(false);
                        }

                    } else {
                        // echo "has ";return;
                        $model = new \backend\models\Cardaily();
                        $model->car_id = $car_id;
                        $model->employee_id = $emp_id[$i];
                        $model->trans_date = $t_date;
                        $model->is_driver = $isdriver[$i] == 1 ? 1 : 0;
                        $model->status = 1;
                        $model->company_id = $company_id;
                        $model->branch_id = $branch_id;
                        $model->save(false);
                    }

                }
                $this->updateOrderEmp($car_id, $t_date);
            }
        }

//        $searchModel = new CardailySearch();
//        $searchModel->trans_date = $t_date;
//        $searchModel->route_id = $route_id;
        return $this->redirect(['index', ['route_id' => $route_id, 'trans_date' => $t_date]]);
    }

    public function updateOrderEmp($car_id, $tdate)
    {
        if ($car_id != null && $tdate != null) {

            $model_x = \backend\models\Cardaily::find()->where(['car_id' => $car_id, 'date(trans_date)' => date('Y-m-d', strtotime($tdate))])->count('employee_id');
            if ($model_x) {

                $model = \backend\models\Orders::find()->where(['car_ref_id' => $car_id, 'date(order_date)' => date('Y-m-d', strtotime($tdate))])->one();
                if ($model) {
                    $model->emp_count = $model_x;
                    $model->save(false);
                }
            }

        }
    }

    public function checkOld($emp_id, $car_id, $t_date, $company_id,$branch_id)
    {
        $model = \backend\models\Cardaily::find()->where(['employee_id' => $emp_id, 'date(trans_date)' => $t_date,'company_id'=>$company_id,'branch_id'=>$branch_id])->count();
//        if ($model>0) {
//            \backend\models\Cardaily::deleteAll(['car_id' => $car_id, 'employee_id' => $emp_id, 'date(trans_date)' => $t_date]);
//        }
        return $model;
    }

    public function actionCopydailytrans()
    {


        $company_id = 1;
        $branch_id = 1;
        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }

        $f_date = \Yii::$app->request->post('from_date');
        $t_date = \Yii::$app->request->post('to_date');
        $res = 0;

        // echo "ok";return;

        if ($f_date != '' && $t_date != '') {
            $from_date = null;
            $to_date = null;
            $a = explode('/', $f_date);
            if (count($a) > 1) {
                $from_date = $a[2] . '/' . $a[1] . '/' . $a[0];
            }
            $b = explode('/', $t_date);
            if (count($b) > 1) {
                $to_date = $b[2] . '/' . $b[1] . '/' . $b[0];
            }

            //  $model = \backend\models\Cardaily::find()->where(['AND', ['>=', 'date(trans_date)', $from_date], ['<=', 'date(trans_date)', $to_date]])->all();
            $model = \backend\models\Cardaily::find()->where(['date(trans_date)' => $from_date, 'company_id' => $company_id, 'branch_id' => $branch_id])->all();
            if ($model) {
                //foreach ($model as $value) {
                \backend\models\Cardaily::deleteAll(['date(trans_date)' => $to_date, 'company_id' => $company_id, 'branch_id' => $branch_id]);
                foreach ($model as $line_value) {
                    if ($this->check_dup($line_value->employee_id, $line_value->car_id, date('Y-m-d', strtotime($to_date)))) {
                        continue;
                    }

                    //  \backend\models\Cardaily::deleteAll(['car_id'=>$line_value->car_id,'trans_date'=>$to_date]);

                    $model_assign_line = new \backend\models\Cardaily();
                    $model_assign_line->car_id = $line_value->car_id;
                    $model_assign_line->employee_id = $line_value->employee_id;
                    $model_assign_line->is_driver = $line_value->is_driver;
                    $model_assign_line->status = 1;
                    $model_assign_line->company_id = $company_id;
                    $model_assign_line->branch_id = $branch_id;
                    $model_assign_line->trans_date = date('Y-m-d', strtotime($to_date));
                    if ($model_assign_line->save(false)) {
                        $res += 1;
                    }
                }
                //}
            }
            if ($res > 0) {
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกรายการเรียบร้อย');
                return $this->redirect(['cardaily/index']);
            }
        }
        return $this->redirect(['cardaily/index']);
    }

    public function check_dup($emp_id, $car_id, $t_date)
    {
        $model = 0;
        $model = \backend\models\Cardaily::find()->where(['employee_id' => $emp_id, 'car_id' => $car_id])->andFilterWhere(['AND', ['>=', 'date(trans_date)', $t_date], ['<=', 'date(trans_date)', $t_date]])->count();
        return $model;
    }

    public function actionCopyfromoriginal()
    {
        $company_id = 1;
        $branch_id = 1;
        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }

        $t_date = \Yii::$app->request->post('to_date');
        $res = 0;

        // echo "ok";return;

        if ($t_date != '') {

            $to_date = null;
            $b = explode('/', $t_date);
            if (count($b) > 1) {
                $to_date = $b[2] . '/' . $b[1] . '/' . $b[0];
            }

            $model = \common\models\CarEmp::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->all();
            if ($model) {
                //foreach ($model as $value) {
                \backend\models\Cardaily::deleteAll(['date(trans_date)' => $to_date, 'company_id' => $company_id, 'branch_id' => $branch_id]);
                foreach ($model as $line_value) {
                    $model_assign_line = new \backend\models\Cardaily();
                    $model_assign_line->car_id = $line_value->car_id;
                    $model_assign_line->employee_id = $line_value->emp_id;
                    $model_assign_line->status = 1;
                    $model_assign_line->company_id = $company_id;
                    $model_assign_line->branch_id = $branch_id;
                    $model_assign_line->trans_date = date('Y-m-d', strtotime($to_date));
                    if ($model_assign_line->save(false)) {
                        $res += 1;
                    }
                }
                //}
            }
            if ($res > 0) {
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกรายการเรียบร้อย');
                return $this->redirect(['cardaily/index']);
            }
        }
        return $this->redirect(['cardaily/index']);
    }
}
