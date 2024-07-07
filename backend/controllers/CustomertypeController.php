<?php

namespace backend\controllers;

use backend\models\CustomergroupSearch;
use backend\models\EmployeeSearch;
use Yii;
use backend\models\Customertype;
use backend\models\CustomertypeSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CustomertypeController extends Controller
{
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
                            $currentRoute = Yii::$app->controller->getRoute();
                            if(Yii::$app->user->can($currentRoute)){
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
        $viewstatus = 1;

        if(\Yii::$app->request->get('viewstatus')!=null){
            $viewstatus = \Yii::$app->request->get('viewstatus');
        }

        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new CustomertypeSearch();
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
        $model = new Customertype();


        if ($model->load(Yii::$app->request->post())) {
            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            if($model->save()){
                $session = Yii::$app->session;
                $session->setFlash('msg', 'ดำเนินการเรียบร้อย');
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

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                $session = Yii::$app->session;
                $session->setFlash('msg', 'ดำเนินการเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
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
        if (($model = Customertype::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
