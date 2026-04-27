<?php

namespace backend\controllers;

use backend\models\Customer;
use backend\models\Orders;
use backend\models\ProductgroupSearch;
use backend\models\WarehouseSearch;
use Yii;
use backend\models\Car;
use backend\models\CarSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CarController implements the CRUD actions for Car model.
 */
class CarController extends Controller
{
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
     * Lists all Car models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $user_roles = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
//        if ($user_roles != null) {
//            foreach ($user_roles as $value) {
//               echo $value->name;
//            }
//        }
//
//        return false;
//
//
//        if ($model != null) {
//            echo "ok";return;
//        }
    //    $next_date = date('Y-m-d H:i:s', strtotime("+1 day", strtotime('2021/12/19 09:58')));
//        $sdate = '2021/12/19';
//        $next_date = date('Y-m-d H:i:s', strtotime("+1 day", strtotime($sdate.' '.date('H:i:s'))));
//        echo $next_date;return;
//        $sql = "select route_id,product_id,sum(avl_qty) AS avl_qty";
//        $sql .= " FROM order_stock";
//        $sql .= " WHERE  route_id =" . 873;
//        $sql .= " AND date(trans_date) =" . "'" . date('Y-m-d') . "'" . " ";
//        $sql .= " GROUP BY route_id, product_id ";
//
//        $sql_query = \Yii::$app->db->createCommand($sql);
//        $stock_data = $sql_query->queryAll();
//        echo $stock_data[0]['product_id'];return;
        // $runno = \backend\models\Ordermobile::getLastNoMobile(1,2);
        //   $model = Orders::find()->where(['date(order_date)' => date('Y-m-d')])->andFilterWhere(['company_id' => 1, 'branch_id' => 2])->MAX('order_no');
//        $model = Orders::find()->where(['date(order_date)' => date('Y-m-d')])->andFilterWhere(['company_id' => 1, 'branch_id' => 2,'sale_from_mobile'=>1])->andFilterWhere(['like','order_no','CO'])->MAX('order_no');
        //      echo $model;return;
        //  $model = \common\models\LoginLogCal::find()->select('MAX(login_date) as login_date')->where(['user_id' => 1, 'status' => 1])->one();
        //  echo $model->login_date; return;
//        $x = \backend\models\Stockjournal::getLastNoNew(1,1,27,3);
//        echo $x; return;
//        $pre_date = date('Y-m-d', strtotime(date('Y-m-d') . " -1 day"));
//        echo $pre_date;return;
//        $max_id = \common\models\LoginLogCal::find()->where(['user_id'=>7])->max('id');
//        if($max_id > 0 || $max_id !=null){
//            // $login_date = $max_id;
//            $model = \common\models\LoginLogCal::find()->where(['<','id',$max_id])->orderBy(['id'=>SORT_DESC])->one();
//            if($model){
//                $login_date = date('d-m-Y H:i:s', strtotime($model->login_date));
//            }
//        }
//        echo $login_date;return;


        $viewstatus = 1;

        if(\Yii::$app->request->get('viewstatus')!=null){
            $viewstatus = \Yii::$app->request->get('viewstatus');
        }

        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new CarSearch();
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
     * Displays a single Car model.
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
     * Creates a new Car model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
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
        $model = new Car();
        if ($model->load(Yii::$app->request->post())) {
            $emp_list = $model->emp_id;
            // print_r($emp_list);return;
            $photo = UploadedFile::getInstance($model, 'photo');
            if (!empty($photo)) {
                $photo_name = time() . "." . $photo->getExtension();
                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/car/' . $photo_name);
                $model->photo = $photo_name;
            }
            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            if ($model->save()) {
                if (count($emp_list) > 0) {
                    \common\models\CarEmp::deleteAll(['car_id' => $model->id]);
                    for ($i = 0; $i <= count($emp_list) - 1; $i++) {
                        $model_check = \common\models\CarEmp::find()->where(['car_id' => $model->id, 'emp_id' => $emp_list[$i]])->one();
                        if ($model_check) {

                        } else {
                            $model_x = new \common\models\CarEmp();
                            $model_x->car_id = $model->id;
                            $model_x->emp_id = $emp_list[$i];
                            $model_x->status = 1;
                            $model_x->company_id = $company_id;
                            $model_x->branch_id = $branch_id;
                            $model_x->save();
                        }
                    }
                }
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
//        print_r($model_emp);return;
        if ($model->load(Yii::$app->request->post())) {
            $photo = UploadedFile::getInstance($model, 'photo');
            if (!empty($photo)) {
                $photo_name = time() . "." . $photo->getExtension();
                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/car/' . $photo_name);
                $model->photo = $photo_name;
            }
            $emp_list = $model->emp_id;
            if ($model->save()) {
                if ($emp_list != null && count($emp_list) > 0) {
                    \common\models\CarEmp::deleteAll(['car_id' => $model->id]);
                    for ($i = 0; $i <= count($emp_list) - 1; $i++) {
                        $model_x = new \common\models\CarEmp();
                        $model_x->car_id = $model->id;
                        $model_x->emp_id = $emp_list[$i];
                        $model_x->status = 1;
                        $model_x->save();

                    }
                }
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            }
        }
        $emp_select_list = [];
        $model_emp = \common\models\CarEmp::find()->where(['car_id' => $id])->all();
        foreach ($model_emp as $xx) {
            array_push($emp_select_list, $xx->emp_id);
        }

        return $this->render('update', [
            'model' => $model,
            'emp_select_list' => $emp_select_list
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $session = Yii::$app->session;
        $session->setFlash('msg', 'ดำเนินการเรียบร้อย');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
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
                if (unlink('../web/uploads/images/car/' . $photo)) {
                    Car::updateAll(['photo' => ''], ['id' => $id]);
                }
            }

        }
        return $this->redirect(['car/update', 'id' => $id]);
    }

    public function getPhotoName($id)
    {
        $photo_name = '';
        if ($id) {
            $model = Car::find()->where(['id' => $id])->one();
            if ($model) {
                $photo_name = $model->photo;
            }
        }
        return $photo_name;
    }
}
