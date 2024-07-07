<?php

namespace backend\controllers;

use backend\models\CustomerSearch;
use backend\models\Product;
use Yii;
use backend\models\Company;
use backend\models\Addressbook;
use backend\models\CompanySearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
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

    /**
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $modelx = Company::find()->one();
//        $model_address = new Addressbook();
//        if ($modelx != null) {
//            return $this->redirect(['update', 'id' => $modelx->id]);
//        }
//        $model = new Company();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['update', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//                'model_address' => $model_address,
//                'model_address_plant' => null,
//                //'model_bankaccount' => $model_bankaccount,
//            ]);
//        }
//        $searchModel = new CompanySearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new CompanySearch();
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
     * Displays a single Company model.
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
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();
        if ($model->load(Yii::$app->request->post())) {
            $photo = UploadedFile::getInstance($model, 'logo');
            if (!empty($photo)) {
                $photo_name = time() . "." . $photo->getExtension();
                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/company/' . $photo_name);
                $model->logo = $photo_name;
            }

            if($model->save()){
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
        $model_branch = \backend\models\Branch::find()->where(['company_id'=>$id])->all();
        if ($model->load(Yii::$app->request->post())) {
            $photo = UploadedFile::getInstance($model, 'logo');
            if (!empty($photo)) {
                $photo_name = time() . "." . $photo->getExtension();
                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/company/' . $photo_name);
                $model->logo = $photo_name;
            }
            if($model->save()){
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'model_branch' => $model_branch
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
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
                if (unlink('../web/uploads/images/company/' . $photo)) {
                    Company::updateAll(['logo' => ''], ['id' => $id]);
                }
            }

        }
        return $this->redirect(['company/update', 'id' => $id]);
    }
    public function getPhotoName($id)
    {
        $photo_name = '';
        if ($id) {
            $model = Company::find()->where(['id' => $id])->one();
            if ($model) {
                $photo_name = $model->logo;
            }
        }
        return $photo_name;
    }
}
