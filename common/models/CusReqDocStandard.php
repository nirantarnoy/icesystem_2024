<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cus_req_doc_standard".
 *
 * @property int $id
 * @property string|null $name
 */
class CusReqDocStandard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cus_req_doc_standard';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
