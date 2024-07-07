<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_order_customer_product".
 *
 * @property int $id
 * @property string|null $order_no
 * @property string|null $order_date
 * @property string|null $code
 * @property string|null $name
 * @property int|null $product_id
 * @property int|null $customer_id
 * @property float|null $qty
 * @property float|null $price
 * @property float|null $line_total
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $status
 * @property int|null $order_channel_id
 */
class QueryOrderCustomerProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_order_customer_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'customer_id', 'company_id', 'branch_id', 'status', 'order_channel_id'], 'integer'],
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
            'order_date' => 'Order Date',
            'code' => 'Code',
            'name' => 'Name',
            'product_id' => 'Product ID',
            'customer_id' => 'Customer ID',
            'qty' => 'Qty',
            'price' => 'Price',
            'line_total' => 'Line Total',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'status' => 'Status',
            'order_channel_id' => 'Order Channel ID',
        ];
    }
}
