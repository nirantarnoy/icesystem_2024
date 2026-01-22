<?php

namespace backend\controllers;

use Yii;
use backend\models\QueryMarketingSession;
use backend\models\QueryMarketingSessionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;


/**
 * MarketingsessionController implements the CRUD actions for QueryMarketingSession model.
 */
class MarketingsessionController extends Controller
{
    public $enableCsrfValidation = false;

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
     * Lists all QueryMarketingSession models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QueryMarketingSessionSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);

        $query = QueryMarketingSession::find()
            ->from(['t1' => 'login_route_log'])
            ->select([
                't2.id as user_id',
                't3.fname',
                't3.lname',
                't4.name as route_name',
                't1.route_id',
                'MAX(t1.login_date) as login_date'
            ])
            ->innerJoin('user t2', 't2.employee_ref_id = t1.emp_1 OR t2.employee_ref_id = t1.emp_2')
            ->innerJoin('employee t3', 't3.id = t2.employee_ref_id')
            ->leftJoin('delivery_route t4', 't4.id = t1.route_id')
            ->where(['t3.position' => 3])
            ->andWhere(['>=', 't1.login_date', '2026-01-01 00:00:00'])
            ->groupBy(['t2.id', 't1.route_id', 'DATE(t1.login_date)', 't3.fname', 't3.lname', 't4.name'])
            ->orderBy(['MAX(t1.login_date)' => SORT_DESC]);

        if ($searchModel->load($params)) {
            if ($searchModel->fname) {
                $query->andFilterWhere(['like', 't3.fname', $searchModel->fname]);
            }
            if ($searchModel->lname) {
                $query->andFilterWhere(['like', 't3.lname', $searchModel->lname]);
            }
            if ($searchModel->route_name) {
                $query->andFilterWhere(['like', 't4.name', $searchModel->route_name]);
            }
            if ($searchModel->login_date) {
                $query->andFilterWhere(['like', 't1.login_date', $searchModel->login_date]);
            }
            if ($searchModel->from_date) {
                $query->andFilterWhere(['>=', 't1.login_date', $searchModel->from_date . ' 00:00:00']);
            }
            if ($searchModel->to_date) {
                $query->andFilterWhere(['<=', 't1.login_date', $searchModel->to_date . ' 23:59:59']);
            }
            if ($searchModel->globalSearch) {
                $query->andFilterWhere(['or',
                    ['like', 't3.fname', $searchModel->globalSearch],
                    ['like', 't3.lname', $searchModel->globalSearch],
                    ['like', 't4.name', $searchModel->globalSearch],
                ]);
            }
        }

        $dataProvider->query = $query;
        $dataProvider->sort->attributes = [
            'login_date' => [
                'asc' => ['MAX(t1.login_date)' => SORT_ASC],
                'desc' => ['MAX(t1.login_date)' => SORT_DESC],
                'label' => 'วันที่',
            ],
            'fname' => [
                'asc' => ['t3.fname' => SORT_ASC],
                'desc' => ['t3.fname' => SORT_DESC],
            ],
            'lname' => [
                'asc' => ['t3.lname' => SORT_ASC],
                'desc' => ['t3.lname' => SORT_DESC],
            ],
            'route_name' => [
                'asc' => ['t4.name' => SORT_ASC],
                'desc' => ['t4.name' => SORT_DESC],
            ],
        ];
        $dataProvider->sort->defaultOrder = ['login_date' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionDetails($user_id, $route_name, $date = null)
    {
        $searchModel = new QueryMarketingSessionSearch();
        $params = Yii::$app->request->queryParams;
        $params['QueryMarketingSessionSearch']['user_id'] = $user_id;
        $params['QueryMarketingSessionSearch']['route_name'] = $route_name;
        
        $dataProvider = $searchModel->search($params);
        if ($date) {
            $dataProvider->query->andWhere(['DATE(query_marketing_session.created_at)' => $date]);
        }

        return $this->render('details', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_id' => $user_id,
            'route_name' => $route_name,
            'date' => $date,
        ]);
    }


    /**
     * Displays a single QueryMarketingSession model.
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
     * Export to Excel
     */
    public function actionExport()
    {
        $searchModel = new QueryMarketingSessionSearch();
        $params = Yii::$app->request->queryParams;
        
        $query = QueryMarketingSession::find()
            ->from(['t1' => 'login_route_log'])
            ->select([
                't2.id as user_id',
                't3.fname',
                't3.lname',
                't4.name as route_name',
                't1.route_id',
                'MAX(t1.login_date) as login_date'
            ])
            ->innerJoin('user t2', 't2.employee_ref_id = t1.emp_1 OR t2.employee_ref_id = t1.emp_2')
            ->innerJoin('employee t3', 't3.id = t2.employee_ref_id')
            ->leftJoin('delivery_route t4', 't4.id = t1.route_id')
            ->where(['t3.position' => 3])
            ->andWhere(['>=', 't1.login_date', '2026-01-01 00:00:00'])
            ->groupBy(['t2.id', 't1.route_id', 'DATE(t1.login_date)', 't3.fname', 't3.lname', 't4.name'])
            ->orderBy(['MAX(t1.login_date)' => SORT_DESC]);

        if ($searchModel->load($params)) {
             if ($searchModel->fname) {
                $query->andFilterWhere(['like', 't3.fname', $searchModel->fname]);
            }
            if ($searchModel->lname) {
                $query->andFilterWhere(['like', 't3.lname', $searchModel->lname]);
            }
            if ($searchModel->route_name) {
                $query->andFilterWhere(['like', 't4.name', $searchModel->route_name]);
            }
            if ($searchModel->login_date) {
                $query->andFilterWhere(['like', 't1.login_date', $searchModel->login_date]);
            }
            if ($searchModel->from_date) {
                $query->andFilterWhere(['>=', 't1.login_date', $searchModel->from_date . ' 00:00:00']);
            }
            if ($searchModel->to_date) {
                $query->andFilterWhere(['<=', 't1.login_date', $searchModel->to_date . ' 23:59:59']);
            }
        }
        
        $models = $query->all();

        $fileName = "marketing_report_" . date('YmdHis') . ".xls";
        header("Content-Type: application/x-msexcel ; name=\"$fileName\" ;charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");

        print "\xEF\xBB\xBF"; // UTF-8 BOM

        echo '<table border="1">
            <thead>
            <tr>
                <th>#</th>
                <th>เลขที่</th>
                <th>วันที่</th>
                <th>เวลาเข้าระบบ</th>
                <th>เจ้าหน้าที่ตลาด</th>

                <th>สาย</th>
                <th>ชื่อร้าน</th>
                <th>ประเภทกิจกรรม</th>
                <th>รายละเอียด</th>
                <th>ยืมถัง</th>
                <th>เก็บถัง</th>
                <th>รูปภาพ</th>
                <th>เช็คอินกิจกรรม</th>
                <th>เช็คเอาท์กิจกรรม</th>
                <th>เช็คอิน (Session)</th>
                <th>เช็คเอาท์ (Session)</th>
                <th>พิกัดเช็คอิน</th>
                <th>พิกัดเช็คเอาท์</th>
            </tr>
            </thead>
            <tbody>';
        
        $i = 0;
        foreach ($models as $model) {
            $i++;
            echo '<tr>
                <td>' . $i . '</td>
                <td>-</td>
                <td>' . ($model->login_date ? date('d/m/Y', strtotime($model->login_date)) : '-') . '</td>
                <td>' . ($model->login_date ? date('H:i:s', strtotime($model->login_date)) : '-') . '</td>
                <td>' . $model->fname . ' ' . $model->lname . '</td>
                <td>' . $model->route_name . '</td>
                <td colspan="12" style="text-align: center; color: #999;">(ดูรายละเอียดในระบบ)</td>
            </tr>';
        }



        echo '</tbody></table>';
    }

    /**
     * Finds the QueryMarketingSession model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QueryMarketingSession the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = QueryMarketingSession::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
