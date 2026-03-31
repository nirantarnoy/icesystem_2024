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
     //   $params['QueryMarketingSessionSearch']['route_name'] = $route_name;
        
        $dataProvider = $searchModel->search($params);
        if ($date) {
            $dataProvider->query->andWhere(['DATE(query_marketing_session.created_at)' => $date]);
        }
        
        $dataProvider->query->andWhere(['not', ['query_marketing_session.route_name' => null]]);
        $dataProvider->query->andWhere(['!=', 'query_marketing_session.route_name', '']);
        $dataProvider->query->andWhere(['not', ['query_marketing_session.activity_type' => null]]);
        $dataProvider->query->andWhere(['!=', 'query_marketing_session.activity_type', '']);

        $dataProvider->query->leftJoin('user t2', 't2.id = query_marketing_session.user_id');
        $dataProvider->query->leftJoin('employee t3', 't3.id = t2.employee_ref_id');

        $dataProvider->query->select([
            'DATE(query_marketing_session.created_at) as created_at',
            'query_marketing_session.user_id',
            't2.username as username',
            't3.fname as fname',
            't3.lname as lname',
            'query_marketing_session.route_name',
            'query_marketing_session.shop_name',
            'query_marketing_session.activity_type',
            'GROUP_CONCAT(query_marketing_session.photo_path) as photo_path',
            'query_marketing_session.event_detail',
            'MAX(query_marketing_session.check_in_time) as check_in_time',
            'MAX(query_marketing_session.check_out_time) as check_out_time',
            'MAX(query_marketing_session.check_in_lat) as check_in_lat',
            'MAX(query_marketing_session.check_in_long) as check_in_long',
            'MAX(query_marketing_session.check_out_lat) as check_out_lat',
            'MAX(query_marketing_session.check_out_long) as check_out_long'
        ]);
        $dataProvider->query->groupBy([
            'DATE(query_marketing_session.created_at)',
            'query_marketing_session.user_id',
            't2.username',
            't3.fname',
            't3.lname',
            'query_marketing_session.route_name',
            'query_marketing_session.shop_name',
            'query_marketing_session.activity_type'
        ]);

        $officer_name = '';
        $sql = "SELECT t1.username, t3.fname, t3.lname 
                FROM user t1 
                INNER JOIN employee t3 ON t1.employee_ref_id = t3.id 
                WHERE t1.id = :id";
        $data = Yii::$app->db->createCommand($sql)->bindValue(':id', $user_id)->queryOne();
        if ($data) {
            $officer_name = '(' . $data['username'] . ') ' . $data['fname'] . ' ' . $data['lname'];
        }

        return $this->render('details', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_id' => $user_id,
            'route_name' => $route_name,
            'date' => $date,
            'officer_name' => $officer_name,
        ]);
    }


    public function actionThumb($name)
    {
        $file_path = Yii::getAlias('@webroot/uploads/marketing/') . $name;
        if (!file_exists($file_path)) {
            $file_path = Yii::getAlias('@backend/web/uploads/marketing/') . $name;
        }
        if (!file_exists($file_path)) {
             $file_path = Yii::getAlias('@frontend/web/uploads/marketing/') . $name;
        }

        if (file_exists($file_path)) {
            $info = getimagesize($file_path);
            if ($info) {
                $width = $info[0];
                $height = $info[1];
                $mime = $info['mime'];

                $new_width = 150;
                $new_height = floor($height * ($new_width / $width));

                switch ($mime) {
                    case 'image/jpeg':
                        $image = imagecreatefromjpeg($file_path);
                        break;
                    case 'image/png':
                        $image = imagecreatefrompng($file_path);
                        break;
                    case 'image/gif':
                        $image = imagecreatefromgif($file_path);
                        break;
                    default:
                        return Yii::$app->response->sendFile($file_path);
                }

                $thumb = imagecreatetruecolor($new_width, $new_height);
                if ($mime == 'image/png' || $mime == 'image/gif') {
                    imagealphablending($thumb, false);
                    imagesavealpha($thumb, true);
                }

                imagecopyresampled($thumb, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                header('Content-Type: ' . $mime);
                switch ($mime) {
                    case 'image/jpeg':
                        imagejpeg($thumb, null, 75);
                        break;
                    case 'image/png':
                        imagepng($thumb);
                        break;
                    case 'image/gif':
                        imagegif($thumb);
                        break;
                }

                imagedestroy($image);
                imagedestroy($thumb);
                exit;
            }
        }
        return '';
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
        
        $user_id = isset($params['QueryMarketingSessionSearch']['user_id']) ? $params['QueryMarketingSessionSearch']['user_id'] : null;

        if ($user_id) {
            $query = QueryMarketingSession::find();
            $this->loadSearch($searchModel, $params, $query);
            
            $query->andWhere(['not', ['query_marketing_session.route_name' => null]]);
            $query->andWhere(['!=', 'query_marketing_session.route_name', '']);
            $query->andWhere(['not', ['query_marketing_session.activity_type' => null]]);
            $query->andWhere(['!=', 'query_marketing_session.activity_type', '']);

            $query->leftJoin('user t2', 't2.id = query_marketing_session.user_id');
            $query->leftJoin('employee t3', 't3.id = t2.employee_ref_id');

            $query->select([
                'DATE(query_marketing_session.created_at) as created_at',
                'query_marketing_session.user_id',
                't2.username as username',
                't3.fname as fname',
                't3.lname as lname',
                'query_marketing_session.route_name',
                'query_marketing_session.shop_name',
                'query_marketing_session.activity_type',
                'GROUP_CONCAT(query_marketing_session.photo_path) as photo_path',
                'query_marketing_session.event_detail',
                'query_marketing_session.rent_borrow_tank',
                'query_marketing_session.collect_tank',
                'MAX(query_marketing_session.check_in_time) as check_in_time',
                'MAX(query_marketing_session.check_out_time) as check_out_time',
                'MAX(query_marketing_session.check_in_lat) as check_in_lat',
                'MAX(query_marketing_session.check_in_long) as check_in_long',
                'MAX(query_marketing_session.check_out_lat) as check_out_lat',
                'MAX(query_marketing_session.check_out_long) as check_out_long'
            ]);
            $query->groupBy([
                'DATE(query_marketing_session.created_at)',
                'query_marketing_session.user_id',
                't2.username',
                't3.fname',
                't3.lname',
                'query_marketing_session.route_name',
                'query_marketing_session.shop_name',
                'query_marketing_session.activity_type'
            ]);
            $models = $query->all();

            $fileName = "marketing_details_" . date('YmdHis') . ".xls";
            $this->sendExcelHeaders($fileName);

            echo '<table border="1">
                <thead>
                <tr>
                    <th>#</th>
                    <th>สาย</th>
                    <th>ชื่อร้าน</th>
                    <th>ประเภทกิจกรรม</th>
                    <th>รายงานขาย</th>
                    <th>ยืมถัง</th>
                    <th>เก็บถัง</th>
                    <th>รูปภาพ</th>
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
                    <td>' . $model->route_name . '</td>
                    <td>' . $model->shop_name . '</td>
                    <td>' . $model->activity_type . '</td>
                    <td>' . $model->event_detail . '</td>
                    <td>' . ($model->rent_borrow_tank == 1 ? 'Y' : 'N') . '</td>
                    <td>' . ($model->collect_tank == 1 ? 'Y' : 'N') . '</td>
                    <td>' . $model->photo_path . '</td>
                    <td>' . $model->check_in_time . '</td>
                    <td>' . $model->check_out_time . '</td>
                    <td>' . ($model->check_in_lat . ',' . $model->check_in_long) . '</td>
                    <td>' . ($model->check_out_lat . ',' . $model->check_out_long) . '</td>
                </tr>';
            }
            echo '</tbody></table>';

        } else {
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
            $this->sendExcelHeaders($fileName);

            echo '<table border="1">
                <thead>
                <tr>
                    <th>#</th>
                    <th>วันที่</th>
                    <th>เวลาเข้าระบบ</th>
                    <th>เจ้าหน้าที่ตลาด</th>

                    <th>สาย</th>
                    <th>สถานะ</th>
                </tr>
                </thead>
                <tbody>';
            
            $i = 0;
            foreach ($models as $model) {
                $i++;
                echo '<tr>
                    <td>' . $i . '</td>
                    <td>' . ($model->login_date ? date('d/m/Y', strtotime($model->login_date)) : '-') . '</td>
                    <td>' . ($model->login_date ? date('H:i:s', strtotime($model->login_date)) : '-') . '</td>
                    <td>' . $model->fname . ' ' . $model->lname . '</td>
                    <td>' . $model->route_name . '</td>
                    <td>-</td>
                </tr>';
            }
            echo '</tbody></table>';
        }
    }

    protected function loadSearch($searchModel, $params, $query)
    {
        if ($searchModel->load($params)) {
             $query->andFilterWhere([
                'user_id' => $searchModel->user_id,
                'rent_borrow_tank' => $searchModel->rent_borrow_tank,
                'collect_tank' => $searchModel->collect_tank,
            ]);
            $query->andFilterWhere(['like', 'route_name', $searchModel->route_name])
                ->andFilterWhere(['like', 'shop_name', $searchModel->shop_name])
                ->andFilterWhere(['like', 'activity_type', $searchModel->activity_type]);
        }
    }

    protected function sendExcelHeaders($fileName)
    {
        header("Content-Type: application/x-msexcel ; name=\"$fileName\" ;charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "\xEF\xBB\xBF"; // UTF-8 BOM
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
