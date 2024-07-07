<?php

namespace backend\controllers;

use backend\models\CustomerSearch;
use kartik\mpdf\Pdf;
use Yii;
use backend\models\Product;
use backend\models\ProductSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use yii\helpers\ArrayHelper;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = \Yii::$app->request->post("perpage");
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['status'=>1]);
        $dataProvider->setSort(['defaultOrder' => ['item_pos_seq' => SORT_ASC]]);
        $dataProvider->pagination->pageSize = $pageSize;

        $modelupload = new \backend\models\Uploadfile();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $pageSize,
            'modelupload' => $modelupload
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
        $model = new Product();
        $company_id = 0;
        $branch_id = 0;
        $default_warehouse = 0;
        if (!empty(\Yii::$app->user->identity->company_id)) {
            $company_id = \Yii::$app->user->identity->company_id;
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $branch_id = \Yii::$app->user->identity->branch_id;
//            if ($branch_id == 2) {
//                $default_warehouse = 5;
//            }
        }
        if ($model->load(Yii::$app->request->post())) {
            //   $photo = UploadedFile::getInstanceByName('doc_file');
            $photo = UploadedFile::getInstance($model, 'photo');
            if (!empty($photo)) {
                $photo_name = time() . "." . $photo->getExtension();
                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/products/' . $photo_name);
                $model->photo = $photo_name;
            }

            $prod_type = \Yii::$app->request->post('product_type_id');
            $prod_group = \Yii::$app->request->post('product_group_id');
            $status = \Yii::$app->request->post('status');
            $unit = \Yii::$app->request->post('unit_id');
            $sale_status = \Yii::$app->request->post('sale_status');
            $stock_type = \Yii::$app->request->post('stock_type');


            $model->product_group_id = $prod_group;
            $model->product_type_id = $prod_type;
            $model->sale_status = $sale_status;
            $model->unit_id = $unit;
            $model->stock_type = $stock_type;
            $model->status = $status;
            $model->company_id = $company_id;
            $model->branch_id = $branch_id;
            if ($model->save()) {
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
                // return $this->redirect(['view', 'id' => $model->id]);
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

            $photo = UploadedFile::getInstance($model, 'photo');
            if (!empty($photo)) {
                $photo_name = time() . "." . $photo->getExtension();
                $photo->saveAs(Yii::getAlias('@backend') . '/web/uploads/images/products/' . $photo_name);
                $model->photo = $photo_name;
            }

            $prod_type = \Yii::$app->request->post('product_type_id');
            $prod_group = \Yii::$app->request->post('product_group_id');
            $status = \Yii::$app->request->post('status');
            $unit = \Yii::$app->request->post('unit_id');
            $sale_status = \Yii::$app->request->post('sale_status');
            $stock_type = \Yii::$app->request->post('stock_type');


            $model->product_group_id = $prod_group;
            $model->product_type_id = $prod_type;
            $model->sale_status = $sale_status;
            $model->unit_id = $unit;
            $model->stock_type = $stock_type;
            $model->status = $status;
            if ($model->save()) {
                $session = Yii::$app->session;
                $session->setFlash('msg', 'บันทึกข้อมูลเรียบร้อย');
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
        $session->setFlash('msg', 'ลบข้อมูลเรียบร้อย');
        return $this->redirect(['index']);
    }

    public function actionDeleteline()
    {
        $line_id = \Yii::$app->request->post('id');
        $msg = 0;
        if ($line_id) {
            if (\common\models\Product::deleteAll(['id' => $line_id])) {
                $msg = 1;
            }
        }
        echo $msg;
    }

    public function actionDeletephoto()
    {
        $id = \Yii::$app->request->post('delete_id');
        if ($id) {
            $photo = $this->getPhotoName($id);
            if ($photo != '') {
                if (unlink('../web/uploads/images/products/' . $photo)) {
                    Product::updateAll(['photo' => ''], ['id' => $id]);
                }
            }

        }
        return $this->redirect(['product/update', 'id' => $id]);
    }

    public function getPhotoName($id)
    {
        $photo_name = '';
        if ($id) {
            $model = Product::find()->where(['id' => $id])->one();
            if ($model) {
                $photo_name = $model->photo;
            }
        }
        return $photo_name;
    }

    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionExport()
    {
        $type = 'xsl';
        if ($type != '') {

            $contenttype = "";
            $fileName = "";

            if ($type == 'xsl') {
                $contenttype = "application/x-msexcel";
                $fileName = "export_product.xls";
            }
            if ($type == 'csv') {
                $contenttype = "application/csv";
                $fileName = "export_product.csv";
            }

            // header('Content-Encoding: UTF-8');
            header("Content-Type: " . $contenttype . " ; name=\"$fileName\" ;charset=utf-8");
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Transfer-Encoding: binary");
            header("Pragma: no-cache");
            header("Expires: 0");

            print "\xEF\xBB\xBF";

            $model = Product::find()->all();
            // $model = \common\models\QueryProducts::find()->all();
            if ($model) {
                echo "<table border='1'>
                         <tr>
                            <td>รหัสสินค้า</td>
                            <td>ชื่อ</td>
                            <td>ประเภทสินค้า</td>
                            <td>กลุ่มสินค้า</td>
                            <td>สถานะ</td>
                        </tr>";
                foreach ($model as $data) {
                    $type = \backend\models\Producttype::findName($data->product_type_id);
                    $group = \backend\models\Producttype::findName($data->product_group_id);
                    $status = \backend\helpers\ProductStatus::getTypeById($data->status);
                    echo "<tr>
                            <td>$data->code</td>
                            <td>$data->name</td>
                            <td>$type</td>
                            <td>$group</td>
                            <td>$status</td>
                            </tr>";
                }
                echo "</table>";
            }
        }
    }

    public function actionPrintdoc()
    {
        $model = \backend\models\Product::find()->all();

        if ($model) {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                //  'format' => [150,236], //manaul
                'format' => Pdf::FORMAT_A4,
                //'format' =>  Pdf::FORMAT_A5,
                'orientation' => Pdf::ORIENT_LANDSCAPE,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('_print', [
                    'model' => $model,
                ]),
                //'content' => "nira",
                // 'defaultFont' => '@backend/web/fonts/config.php',
                'cssFile' => '@backend/web/css/pdf_reportviews.css',
                'options' => [
                    'title' => 'Product List',
                    'subject' => ''
                ],
                'methods' => [
                    // 'SetHeader' => ['รายงานรหัสสินค้า||Generated On: ' . date("r")],
                    // 'SetFooter' => ['|Page {PAGENO}|'],
                    //'SetFooter'=>'niran',
                ],
                'marginLeft' => 5,
                'marginRight' => 5,
                'marginTop' => 10,
                'marginBottom' => 10,
                'marginFooter' => 5

            ]);

            $defaultConfig = (new ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $pdf->options['fontDir'] = ArrayHelper::merge($fontDirs, [Yii::getAlias('@webroot') . '/css']);
            $pdf->options['fontdata'] = $fontData + [
                    'sarabun' => [
                        'R' => 'thsarabunnew.ttf'
                    ],
                    'kanit' => [
                        'R' => 'kanit-regular.ttf'
                    ]
                ];

            //return $this->redirect(['genbill']);
//            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
//            Yii::$app->response->headers->add('Content-Type', 'application/pdf');
            return $pdf->render();
        }
    }

    public function actionImportproduct()
    {
        //echo "ok";return;
        $model = new \backend\models\Uploadfile();
        $qty_text = [];
        if (Yii::$app->request->post()) {
            $uploaded = UploadedFile::getInstance($model, 'file');
            if (!empty($uploaded)) {
                $upfiles = time() . "." . $uploaded->getExtension();
                if ($uploaded->saveAs('../web/uploads/files/' . $upfiles)) {
                    //echo "okk";return;
                    $myfile = '../web/uploads/files/' . $upfiles;
                    $file = fopen($myfile, "r");
                    fwrite($file, "\xEF\xBB\xBF");

                    setlocale(LC_ALL, 'th_TH.TIS-620');
                    $i = -1;
                    $res = 0;
                    $data = [];
                    while (($rowData = fgetcsv($file, 10000, ",")) !== FALSE) {
                        $i += 1;
                        $code = '';
                        $name = '';
                        $discription = '';

                        if ($rowData[1] == '' || $i == 0) {
                            continue;
                        }

                        $modelprod = \backend\models\Product::find()->where(['name' => $rowData[1]])->one();
                        if (count($modelprod) > 0) {
                            continue;
                        }

                        $modelx = new \backend\models\Product();
                        $modelx->code = $rowData[0];
                        $modelx->name = $rowData[1];
                        $modelx->description = ltrim($rowData[2]);
                        $modelx->status = 1;
                        if ($modelx->save(false)) {
                            $res += 1;
                        }
                    }
                    if ($res > 0) {
                        $session = Yii::$app->session;
                        $session->setFlash('msg', 'นำเข้าข้อมูลสินค้าเรียบร้อย');
                        return $this->redirect(['index']);
                    } else {
                        $session = Yii::$app->session;
                        $session->setFlash('msg-error', 'พบข้อมผิดพลาด');
                        return $this->redirect(['index']);
                    }
                }
                fclose($file);
            } else {
                $session = Yii::$app->session;
                $session->setFlash('msg-error', 'พบข้อมผิดพลาด');
                return $this->redirect(['index']);
            }
        }
    }
}

?>
