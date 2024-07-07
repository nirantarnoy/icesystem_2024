<?php
namespace backend\controllers;

use backend\models\ProductSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ProductionrecController extends Controller
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
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
       return $this->render('_index');
    }
}
