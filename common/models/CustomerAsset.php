<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_asset".
 *
 * @property int $id
 * @property int|null $customer_id
 * @property int|null $product_id
 * @property float|null $qty
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $status
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class CustomerAsset extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_asset';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'product_id', 'status', 'company_id', 'branch_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['qty'], 'number'],
            [['start_date', 'end_date'], 'safe'],
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
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
