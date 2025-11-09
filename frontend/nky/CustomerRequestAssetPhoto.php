<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_request_doc".
 *
 * @property int $id
 * @property int|null $customer_req_id
 * @property int|null $doc_id
 */
class CustomerRequestAssetPhoto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_request_asset_photo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_req_id','status'], 'integer'],
            [['photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_req_id' => 'Customer Req ID',
            'photo' => 'Doc ID',
            'status' => 'Status',
        ];
    }
}
