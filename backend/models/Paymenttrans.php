<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

date_default_timezone_set('Asia/Bangkok');

class Paymenttrans extends \common\models\PaymentTrans
{
    public function behaviors()
    {
        return [
            'timestampcdate' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                ],
                'value' => time(),
            ],
            'timestampudate' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'updated_at',
                ],
                'value' => time(),
            ],
            'timestampcby' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_by',
                ],
                'value' => Yii::$app->user->id,
            ],
            'timestamuby' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
                ],
                'value' => Yii::$app->user->id,
            ],
            'timestampupdate' => [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => time(),
            ],
        ];
    }

    public static function getLastNo($company_id, $branch_id)
    {
        $model = Paymenttrans::find()->where(['company_id' => $company_id, 'branch_id' => $branch_id])->MAX('trans_no');
        //$pre = \backend\models\Sequence::find()->where(['module_id'=>15])->one();
        $pre = "IV";
        if ($model) {
            $prefix = $pre . substr(date("Y"), 2, 2);
            $cnum = substr((string)$model, 4, strlen($model));
            $len = strlen($cnum);
            $clen = strlen($cnum + 1);
            $loop = $len - $clen;
            for ($i = 1; $i <= $loop; $i++) {
                $prefix .= "0";
            }
            $prefix .= $cnum + 1;
            return $prefix;
        } else {
            $prefix = $pre . substr(date("Y"), 2, 2);
            return $prefix . '000001';
        }
    }

}
