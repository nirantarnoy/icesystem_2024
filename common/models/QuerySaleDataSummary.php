<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_data_summary".
 *
 * @property int $id
 * @property string|null $order_no
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $created_by
 * @property int|null $order_channel_id
 * @property string|null $order_date
 * @property int|null $product_id
 * @property float|null $qty
 * @property int|null $payment_method_id
 * @property string|null $code
 * @property string|null $name
 * @property float|null $price
 * @property float|null $line_total
 */
class QuerySaleDataSummary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_data_summary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'branch_id', 'created_by', 'order_channel_id', 'product_id', 'payment_method_id'], 'integer'],
            [['order_date'], 'safe'],
            [['qty', 'price', 'line_total'], 'number'],
            [['order_no', 'code', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => 'Order No',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'created_by' => 'Created By',
            'order_channel_id' => 'Order Channel ID',
            'order_date' => 'Order Date',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'payment_method_id' => 'Payment Method ID',
            'code' => 'Code',
            'name' => 'Name',
            'price' => 'Price',
            'line_total' => 'Line Total',
        ];
    }
}
