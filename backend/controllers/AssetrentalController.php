<?php

namespace backend\controllers;

use backend\models\CustomertaxinvoiceSearch;
use Yii;
use backend\models\Assetrental;
use backend\models\AssetrentalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AssetrentalController implements the CRUD actions for Assetrental model.
 */
class AssetrentalController extends Controller
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
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Assetrental models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new AssetrentalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        // if($pageSize != '10000'){
        $dataProvider->pagination->pageSize = $pageSize;
//        }else{
//            $dataProvider->pagination->pageSize = $pageSize;
//        }

        //echo $pageSize;return ;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
            'from_date' => null,
            'to_date' => null,
        ]);
    }

    /**
     * Displays a single Assetrental model.
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
     * Creates a new Assetrental model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Assetrental();

        if ($model->load(Yii::$app->request->post())) {
            $line_asset_id =\Yii::$app->request->post('line_asset_id');
            $line_asset_code = \Yii::$app->request->post('line_asset_code');
            $line_size = \Yii::$app->request->post('line_size');
            $line_price = \Yii::$app->request->post('line_price');
            $line_use_status = \Yii::$app->request->post('line_use_status');
            $line_return_status = \Yii::$app->request->post('line_return_status');


            $fdate = date('Y-m-d');
            $tdata = date('Y-m-d');

            $xfdate = explode('-',$model->use_from);
            if($xfdate!=null){
                if(count($xfdate)>1){
                    $fdate = $xfdate[2].'-'.$xfdate[1].'-'.$xfdate[0];
                }
            }
            $xtdate = explode('-',$model->use_to);
            if($xtdate!=null){
                if(count($xtdate)>1){
                    $tdata = $xtdate[2].'-'.$xtdate[1].'-'.$xtdate[0];
                }
            }


            $model->journal_no = $model::getLastNo(1,1);
            $model->trans_date = date('Y-m-d');
            $model->use_from = date('Y-m-d',strtotime($fdate));
            $model->use_to = date('Y-m-d',strtotime($tdata));

            if($model->save(false)){
                if($line_asset_id != null){
                    for($x=0;$x<=count($line_asset_id)-1;$x++){
                        $model_line = new \common\models\AssetRentalLine();
                        $model_line->asset_rental_id = $model->id;
                        $model_line->asset_id = $line_asset_id[$x];
                        $model_line->remark = $line_size[$x];
                        $model_line->price = $line_price[$x];
                        $model_line->use_status = $line_use_status[$x];
                        $model_line->return_status = $line_return_status[$x];
                        $model_line->save(false);
                    }
                }
                return $this->redirect(['index']);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Assetrental model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_line = \common\models\AssetRentalLine::find()->where(['asset_rental_id' => $id])->all();

        if ($model->load(Yii::$app->request->post())) {
            $line_asset_id =\Yii::$app->request->post('line_asset_id');
            $line_asset_code = \Yii::$app->request->post('line_asset_code');
            $line_size = \Yii::$app->request->post('line_size');
            $line_price = \Yii::$app->request->post('line_price');
            $line_use_status = \Yii::$app->request->post('line_use_status');
            $line_return_status = \Yii::$app->request->post('line_return_status');

            $fdate = date('Y-m-d');
            $tdata = date('Y-m-d');

            $xfdate = explode('-',$model->use_from);
            if($xfdate!=null){
                if(count($xfdate)>1){
                    $fdate = $xfdate[2].'-'.$xfdate[1].'-'.$xfdate[0];
                }
            }
            $xtdate = explode('-',$model->use_to);
            if($xtdate!=null){
                if(count($xtdate)>1){
                    $tdata = $xtdate[2].'-'.$xtdate[1].'-'.$xtdate[0];
                }
            }


            $removelist = \Yii::$app->request->post('removelist');
            $model->use_from = date('Y-m-d',strtotime($fdate));
            $model->use_to = date('Y-m-d',strtotime($tdata));

            if($model->save(false)){
                if($line_asset_id != null){
                   // \common\models\AssetRentalLine::deleteAll(['asset_rental_id' => $model->id]);
                    for($x=0;$x<=count($line_asset_id)-1;$x++){
                        if($line_asset_id[$x] != null){
                            $check = \common\models\AssetRentalLine::find()->where(['asset_rental_id' => $model->id, 'asset_id' => $line_asset_id[$x]])->one();
                            if($check){
                                $model_line = \common\models\AssetRentalLine::find()->where(['asset_rental_id' => $model->id, 'asset_id' => $line_asset_id[$x]])->one();
                                $model_line->remark = $line_size[$x];
                                $model_line->use_status = $line_use_status[$x];
                                $model_line->return_status = $line_return_status[$x];
                                $model_line->save(false);
                            }else{
                                $model_line = new \common\models\AssetRentalLine();
                                $model_line->asset_rental_id = $model->id;
                                $model_line->asset_id = $line_asset_id[$x];
                                $model_line->remark = $line_size[$x];
                                $model_line->price = $line_price[$x];
                                $model_line->use_status = $line_use_status[$x];
                                $model_line->return_status = $line_return_status[$x];
                                $model_line->save(false);
                            }
                        }

                    }
                }

                if($removelist != null){
                    $xdel = explode(',', $removelist);
                    if($xdel != null){
                        for ($i=0;$i<=count($xdel)-1;$i++){
                            $model_line = \common\models\AssetRentalLine::find()->where(['id' => $xdel[$i]])->one();
                            $model_line->delete();
                        }
                    }
                }
                return $this->redirect(['index']);
            }

        }

        return $this->render('update', [
            'model' => $model,
            'model_line' => $model_line
        ]);
    }

    /**
     * Deletes an existing Assetrental model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        \common\models\AssetRentalLine::deleteAll(['asset_rental_id' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Assetrental model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Assetrental the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Assetrental::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFindasset()
    {
        $find_asset = \Yii::$app->request->post('find_asset');
        $model = null;
        if($find_asset != null){
            $model = \backend\models\Assetsitem::find()->where(['status' => 1])->andFilterWhere(['like', 'asset_no', $find_asset])->all();
        }else{
            $model = \backend\models\Assetsitem::find()->where(['status' => 1])->all();
        }

        $html = '';
        if ($model) {
            foreach ($model as $value) {
                if($this->checkAssetUse($value->id) > 0){
                    continue;
                }
                $html .= '<tr data-var="'.$value->id.'">';
                $html .= '<td style="text-align: center">
                            <div class="btn btn-outline-success btn-sm" onclick="addselecteditem($(this))" data-var="' . $value->id . '">เลือก</div>
                            <input type="hidden" class="line-find-asset-id" value="' . $value->id . '">
                            <input type="hidden" class="line-find-asset-size" value="' . $value->description . '">
                            <input type="hidden" class="line-find-asset-code" value="' . $value->asset_no. '">
                            <input type="hidden" class="line-find-asset-price" value="' . $value->rent_price. '">
                           </td>';
                $html .= '<td style="text-align: left">' . $value->description . '</td>';
                $html .= '<td style="text-align: left">' . $value->asset_no . '</td>';
                $html .= '</tr>';
            }

        } else {
            $html .= '<tr>';
            $html .= '<td colspan="9" style="text-align: center;color: red;">';
            $html .= 'ไม่พบข้อมูล inner';
            $html .= '</td>';
            $html .= '</tr>';
        }

        echo $html;
    }

    public function checkAssetUse($asset_id){
       $model = \common\models\CustomerAsset::find()->where(['product_id' => $asset_id])->count();
       return $model;
    }
    public function actionPrint($id)
    {
        if ($id) {
            $model_line = null;
            $model_min_max = [];
            $model = \backend\models\Assetrental::find()->where(['id' => $id])->one();
            if ($model) {
                $model_line = \common\models\AssetRentalLine::find()->where(['asset_rental_id' => $id])->orderBy(['id' => SORT_ASC])->all();
//                if ($model_line) {
//                    foreach ($model_line as $value) {
//                        array_push($model_min_max, ['date' => date('Y-m-d', strtotime(\backend\models\Orders::getOrderdate($value->order_id)))]);
//                    }
//                }
            }
            return $this->render('_print', [
                'model' => $model,
                'model_line' => $model_line,
                'model_min_max' => $model_min_max,
            ]);
        } else {
            return $this->redirect('customerinvoice/index');
        }
    }
}
