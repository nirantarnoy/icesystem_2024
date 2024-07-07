<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_api_order_daily_summary_new".
 *
 * @property int $id
 * @property string|null $order_no
 * @property string|null $order_date
 * @property int|null $status
 * @property int|null $car_ref_id
 * @property int|null $customer_id
 * @property float|null $line_total
 * @property string|null $code
 * @property string|null $name
 * @property int|null $payment_method_id
 * @property float|null $line_qty
 * @property int|null $sale_payment_method_id
 * @property float|null $price
 * @property int $order_line_id
 * @property int|null $product_id
 * @property string|null $product_code
 * @property string|null $product_name
 * @property int|null $created_at
 */
class QueryApiOrderDailySummaryNew extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_api_order_daily_summary_new';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'car_ref_id', 'customer_id', 'payment_method_id', 'sale_payment_method_id', 'order_line_id', 'product_id', 'created_at'], 'integer'],
            [['order_date','order_line_status','customer_ref_no'], 'safe'],
            [['line_total', 'line_qty', 'price'], 'number'],
            [['order_no', 'code', 'name', 'product_code', 'product_name'], 'string', 'max' => 255],
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
            'code' => 'Code',
            'name' => 'Name',
            'payment_method_id' => 'Payment Method ID',
            'line_qty' => 'Line Qty',
            'sale_payment_method_id' => 'Sale Payment Method ID',
            'price' => 'Price',
            'order_line_id' => 'Order Line ID',
            'product_id' => 'Product ID',
            'product_code' => 'Product Code',
            'product_name' => 'Product Name',
            'created_at' => 'Created At',
        ];
    }
}
