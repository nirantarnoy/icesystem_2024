<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_asset_request".
 *
 * @property int $id
 * @property int|null $customer_id
 * @property int|null $asset_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $status
 * @property int|null $company_id
 * @property int|null $branch_id
 */
class CustomerAssetRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_asset_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'asset_id', 'created_at', 'created_by', 'status', 'company_id', 'branch_id'], 'integer'],
            [['location'],'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'asset_id' => 'Asset ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'status' => 'Status',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
        ];
    }
}
