<?php

namespace backend\controllers;

use Yii;
use backend\models\Sequence;
use backend\models\SequenceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * SequenceController implements the CRUD actions for Sequence model.
 */
class SequenceController extends Controller
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
                    'delete' => ['POST','GET'],
                ],
            ],
            'access'=>[
                'class'=>AccessControl::className(),
                'rules'=>[
                    [
                        'allow'=>true,
                        'actions'=>['index','create','update','delete','view','autogen'],
                        'roles'=>['@'],
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Sequence models.
     * @return mixed
     */
    public function actionIndex()
    {

        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new SequenceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
        ]);
    }

    /**
     * Displays a single Sequence model.
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
     * Creates a new Sequence model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sequence();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                $session = Yii::$app->session;
                $session->setFlash('msg','บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Sequence model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                $session = Yii::$app->session;
                $session->setFlash('msg','บันทึกรายการเรียบร้อย');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Sequence model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $session = Yii::$app->session;
//        $modelchecktrans = \backend\models\Journal::find()->where(['trans_type'=>$id])->count();
//        if(!$modelchecktrans){
            $this->findModel($id)->delete();
            $session->setFlash('msg','ลบรายการเรียบร้อย');
            return $this->redirect(['index']);
//        }else{
//
//            $session->setFlash('msg-error','พบข้อผิดพลาดในการทำรายการ');
//            return $this->redirect(['index']);
//        }



    }

    /**
     * Finds the Sequence model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sequence the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sequence::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionAutogen(){
        if(Yii::$app->request->isAjax){
            $gentype = Yii::$app->request->post('autogen');
            if($gentype){
               $x = Sequence::autogen();
               return $this->redirect(['index']);
            }
        }
    }
}
