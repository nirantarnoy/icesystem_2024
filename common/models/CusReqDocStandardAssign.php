<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cus_req_doc_standard_assign".
 *
 * @property int $id
 * @property int|null $cus_req_id
 * @property int|null $cus_req_standard_id
 * @property int|null $cus_req_standard_item_id
 */
class CusReqDocStandardAssign extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cus_req_doc_standard_assign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cus_req_id', 'cus_req_standard_id', 'cus_req_standard_item_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cus_req_id' => 'Cus Req ID',
            'cus_req_standard_id' => 'Cus Req Standard ID',
            'cus_req_standard_item_id' => 'Cus Req Standard Item ID',
        ];
    }
}
