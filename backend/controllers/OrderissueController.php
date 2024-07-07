<?php

namespace backend\controllers;

use backend\models\LocationSearch;
use backend\models\OrderissueSearch;
use Yii;
use backend\models\Journalissue;
use backend\models\JournalissueSearch;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JournalissueController implements the CRUD actions for Journalissue model.
 */
class OrderissueController extends Controller
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
        ];
    }

    /**
     * Lists all Journalissue models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $pageSize = \Yii::$app->request->post("perpage");
//        $searchModel = new OrderissueSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        //$dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
//     //   $dataProvider->query->limit(300);
//        $dataProvider->pagination->pageSize = 300;
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//            'perpage' => $pageSize,
//        ]);
        $from_date = \Yii::$app->request->post('from_date');
        $to_date = \Yii::$app->request->post('to_date');
        $find_user_id = \Yii::$app->request->post('find_user_id');
        $status = \Yii::$app->request->post('status');
         return $this->render('_index_new',[
             'from_date'=>$from_date,
             'to_date'=>$to_date,
             'find_user_id'=>$find_user_id,
             'status'=>$status,

         ]);
    }


    protected function findModel($id)
    {
        if (($model = Journalissue::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
