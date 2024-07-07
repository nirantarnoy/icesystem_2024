<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');

class Sequence extends \common\models\Sequence
{
  public function behaviors()
		{
		    return [
		        'timestampcdate'=>[
		            'class'=> \yii\behaviors\AttributeBehavior::className(),
		            'attributes'=>[
		            ActiveRecord::EVENT_BEFORE_INSERT=>'created_at',
		            ],
		            'value'=> time(),
		        ],
		        'timestampudate'=>[
		            'class'=> \yii\behaviors\AttributeBehavior::className(),
		            'attributes'=>[
		            ActiveRecord::EVENT_BEFORE_INSERT=>'updated_at',
		            ],
		          'value'=> time(),
		        ],
//		        'timestampcby'=>[
//		            'class'=> \yii\behaviors\AttributeBehavior::className(),
//		            'attributes'=>[
//		            ActiveRecord::EVENT_BEFORE_INSERT=>'created_by',
//		            ],
//		          'value'=> Yii::$app->user->identity->id,
//		        ],
//		         'timestamuby'=>[
//		            'class'=> \yii\behaviors\AttributeBehavior::className(),
//		            'attributes'=>[
//		            ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_by',
//		            ],
//		          'value'=> Yii::$app->user->identity->id,
//		        ],
		        'timestampupdate'=>[
		            'class'=> \yii\behaviors\AttributeBehavior::className(),
		            'attributes'=>[
		            ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_at',
		            ],
		            'value'=> time(),
		        ],
		    ];
		 }
       public static function autogen(){
           $x = \backend\helpers\RunnoTitle::asArrayObject();
           $res = 0;
           for ($i=0;$i<=count($x)-1;$i++){
               $model = Sequence::find()->where(['module_id'=>$x[$i]['id']])->one();
              if(!$model){
                 $modelseq = new Sequence();
                 $modelseq->prefix = $x[$i]['prefix'];
                 $modelseq->minimum = 1;
                 $modelseq->maximum = 999999;
                 $modelseq->currentnum = 0;
                 $modelseq->module_id = $x[$i]['id'];
                 $modelseq->use_day = 0;
                 $modelseq->use_month = 0;
                 $modelseq->use_year = 1;
                 $modelseq->symbol = "";
                 $modelseq->status = 1;
                 if($modelseq->save()){
                     $res +=1;
                 }
              }
           }
           if($res){
               return true;
           }else{
               return false;
           }

       }
       public function updateNumber($module_id){

       }
}
