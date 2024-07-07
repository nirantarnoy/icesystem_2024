<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_api_order_daily".
 *
 * @property int $id
 * @property string|null $order_no
 * @property string|null $order_date
 * @property int|null $status
 * @property int|null $car_ref_id
 * @property int|null $customer_id
 * @property float|null $line_total
 * @property string|null $customer_code
 * @property string|null $customer_name
 * @property int|null $payment_method_id
 * @property int $line_id
 * @property int|null $product_id
 * @property string|null $product_code
 * @property string|null $product_name
 * @property float|null $qty
 * @property float|null $price
 */
class QueryApiOrderDaily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_api_order_daily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'car_ref_id', 'customer_id', 'payment_method_id', 'line_id', 'product_id'], 'integer'],
            [['order_date'], 'safe'],
            [['line_total', 'qty', 'price'], 'number'],
            [['order_no', 'customer_code', 'customer_name', 'product_code', 'product_name'], 'string', 'max' => 255],
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
            'status' => 'Status',
            'car_ref_id' => 'Car Ref ID',
            'customer_id' => 'Customer ID',
            'line_total' => 'Line Total',
            'customer_code' => 'Customer Code',
            'customer_name' => 'Customer Name',
            'payment_method_id' => 'Payment Method ID',
            'line_id' => 'Line ID',
            'product_id' => 'Product ID',
            'product_code' => 'Product Code',
            'product_name' => 'Product Name',
            'qty' => 'Qty',
            'price' => 'Price',
        ];
    }
}
