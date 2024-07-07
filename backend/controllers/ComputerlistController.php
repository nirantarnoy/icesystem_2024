<?php

namespace backend\controllers;

use backend\models\EmployeeSearch;
use Yii;
use backend\models\Computerlist;
use backend\models\ComputerlistSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComputerlistController implements the CRUD actions for Computerlist model.
 */
class ComputerlistController extends Controller
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
        ];
    }

    /**
     * Lists all Computerlist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $viewstatus = 1;
        $company_id = \Yii::$app->user->identity->company_id;
        $branch_id = \Yii::$app->user->identity->branch_id;

        if(\Yii::$app->request->get('viewstatus')!=null){
            $viewstatus = \Yii::$app->request->get('viewstatus');
        }

        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new ComputerlistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['company_id'=>$company_id,'branch_id'=>$branch_id]);
//        if($viewstatus ==1){
//            $dataProvider->query->andFilterWhere(['status'=>$viewstatus]);
//        }
//        if($viewstatus == 2){
//            $dataProvider->query->andFilterWhere(['status'=>0]);
//        }

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
     * Displays a single Computerlist model.
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
     * Creates a new Computerlist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Computerlist();

        $company_id = \Yii::$app->user->identity->company_id;
        $branch_id = \Yii::$app->user->identity->branch_id;

        if ($model->load(Yii::$app->request->post())) {
            $listuser = '';
            for($i=0;$i<=count($model->userid)-1;$i++){
                if($i<count($model->userid)-1){
                    $listuser .= $model->userid[$i].",";
                }else{
                    $listuser .= $model->userid[$i];
                }

            }
           // echo $listuser;return;
            $model->userid = $listuser;
            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Computerlist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $listuser = '';
            for($i=0;$i<=count($model->userid)-1;$i++){
                if($i<count($model->userid)-1){
                    $listuser .= $model->userid[$i].",";
                }else{
                    $listuser .= $model->userid[$i];
                }

            }
            // echo $listuser;return;
            $model->userid = $listuser;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Computerlist model.
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
     * Finds the Computerlist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Computerlist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Computerlist::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
