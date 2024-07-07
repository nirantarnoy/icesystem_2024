<?php

namespace backend\controllers;

use backend\models\PlansummarySearch;
use backend\models\RoutesummarySearch;
use Yii;
use backend\models\Plan;
use backend\models\PlanSearch;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
            $removelist = \Yii::$app->request->post('remove_list');


            $x_date = explode('/', $model->trans_date);
            $sale_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $model->trans_date = date('Y-m-d', strtotime($sale_date));
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
            $model->trans_date = date('Y-m-d', strtotime($sale_date));

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
                            \common\models\PlanLine::deleteAll(['id' => $x[$m]]);
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
        if (\backend\models\Planline::deleteAll(['plan_id' => $id])) {
            //$this->findModel($id)->delete();
            if (\common\models\Plan::deleteAll(['id' => $id])) {
                $issue_id = \backend\models\Journalissue::find()->where(['plan_id' => $id])->one();
                if ($issue_id) {
                    \backend\models\Journalissueline::deleteAll(['issue_id' => $issue_id->id]);
                    \backend\models\Journalissue::deleteAll(['plan_id' => $id]);
                }
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
        $to_date = \Yii::$app->request->post('to_date');
        $find_user_id = \Yii::$app->request->post('find_user_id');
        return $this->render('_planoverview',[
            'from_date' => $from_date,
            'to_date' => $to_date,
            //    'find_sale_type'=>$find_sale_type,
            'find_user_id' => $find_user_id,
            'company_id' => $company_id,
            'branch_id' => $branch_id,
        ]);
    }
}
