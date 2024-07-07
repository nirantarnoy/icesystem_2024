<?php

namespace backend\controllers;

use backend\models\LocationSearch;
use Yii;
use backend\models\Journalissue;
use backend\models\JournalissueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JournalissueController implements the CRUD actions for Journalissue model.
 */
class IssuerefillController extends Controller
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
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new JournalissueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['reason_id' => 3]);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        $dataProvider->pagination->pageSize = $pageSize;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
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
        $default_warehouse = 0;
        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
        }

        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
            $warehouse_primary = \backend\models\Warehouse::findPrimary($company_id, $branch_id);
            $default_warehouse = $warehouse_primary;
        }

        $model = new Journalissue();

        if ($model->load(Yii::$app->request->post())) {
            $prod_id = \Yii::$app->request->post('line_prod_id');
            $line_qty = \Yii::$app->request->post('line_qty');
            $line_issue_price = \Yii::$app->request->post('line_issue_line_price');

            $x_date = explode('/', $model->trans_date);
            $sale_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $model->journal_no = $model->getLastNo($sale_date, $company_id, $branch_id);
            $model->trans_date = date('Y-m-d', strtotime($sale_date));
            $model->status = 1;
            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            $model->delivery_route_id = 0;
            $model->reason_id = 3; // 3 refill 4 reprocess
            if ($model->save()) {
                if ($prod_id != null) {
                    for ($i = 0; $i <= count($prod_id) - 1; $i++) {
                        if ($prod_id[$i] == '') continue;

                        $model_line = new \backend\models\Journalissueline();
                        $model_line->issue_id = $model->id;
                        $model_line->product_id = $prod_id[$i];
                        $model_line->qty = $line_qty[$i];
                        $model_line->avl_qty = $line_qty[$i];
                        $model_line->sale_price = $line_issue_price[$i];
                        $model_line->status = 1;
                        if ($model_line->save()) {
                            $this->updateStock($prod_id[$i], $line_qty[$i], $default_warehouse, $model->journal_no, $company_id, $branch_id);
                        }
                    }
                }
                $session = \Yii::$app->session;
                $session->setFlash('msg', 'บันทึกรายการเรียบร้อย');
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function updateStock($product_id, $qty, $wh_id, $journal_no, $company_id, $branch_id)
    {
//        $default_warehouse = 6;
//        if ($company_id == 1 && $branch_id == 2) {
//            $default_warehouse = 5;
//        }
        $company_id = 1;
        $branch_id = 1;
        $default_warehouse = 0; // 6
        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
            $warehouse_primary = \backend\models\Warehouse::findPrimary($company_id, $branch_id);
            $default_warehouse = $warehouse_primary;
        }

        if ($product_id != null && $qty > 0) {
            $model_trans = new \backend\models\Stocktrans();
            $model_trans->journal_no = $journal_no;
            $model_trans->trans_date = date('Y-m-d H:i:s');
            $model_trans->product_id = $product_id;
            $model_trans->qty = $qty;
            $model_trans->warehouse_id = $default_warehouse;
            $model_trans->stock_type = 2; // 1 in 2 out
            $model_trans->activity_type_id = 18; // 1 prod rec 2 issue car
            $model_trans->company_id = $company_id;
            $model_trans->branch_id = $branch_id;
            if ($model_trans->save(false)) {
                $model = \backend\models\Stocksum::find()->where(['warehouse_id' => $default_warehouse, 'product_id' => $product_id])->andFilterWhere(['company_id' => $company_id, 'branch_id' => $branch_id])->one();
                if ($model) {
                    $model->qty = $model->qty - (int)$qty;
                    $model->save(false);
                }
            }
        }
    }

    protected function findModel($id)
    {
        if (($model = Journalissue::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
