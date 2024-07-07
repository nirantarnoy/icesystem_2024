<?php
namespace backend\models;

use yii\base\Model;

class Uploadfile extends Model
{
    public $file;
    public function rules(){
        return [
            [['file'],'required'],
            [['file'],'string']
        ];
    }
    public function attributeLabels(){
        return [
            'file'=>'ไฟล์'
        ];
    }
}

