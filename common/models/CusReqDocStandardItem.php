<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cus_req_doc_standard_item".
 *
 * @property int $id
 * @property int|null $cus_req_standard_id
 * @property string|null $name
 */
class CusReqDocStandardItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cus_req_doc_standard_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cus_req_standard_id'], 'integer'],
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
            'cus_req_standard_id' => 'Cus Req Standard ID',
            'name' => 'Name',
        ];
    }
}
