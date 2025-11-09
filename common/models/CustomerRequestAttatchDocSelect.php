<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_request_attatch_doc_select".
 *
 * @property int $id
 * @property int|null $customer_request_id
 * @property int|null $customer_attatch_doc_id
 */
class CustomerRequestAttatchDocSelect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_request_attatch_doc_select';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_request_id', 'customer_attatch_doc_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_request_id' => 'Customer Request ID',
            'customer_attatch_doc_id' => 'Customer Attatch Doc ID',
        ];
    }
}
