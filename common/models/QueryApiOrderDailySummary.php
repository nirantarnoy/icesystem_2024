<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_api_order_daily_summary".
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
 * @property int|null $pay_type
 * @property string|null $payment_method_name
 * @property float|null $line_qty
 */
class QueryApiOrderDailySummary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_api_order_daily_summary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'car_ref_id', 'customer_id', 'payment_method_id', 'pay_type'], 'integer'],
            [['order_date'], 'safe'],
            [['line_total', 'line_qty'], 'number'],
            [['order_no', 'code', 'name', 'payment_method_name'], 'string', 'max' => 255],
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
            'pay_type' => 'Pay Type',
            'payment_method_name' => 'Payment Method Name',
            'line_qty' => 'Line Qty',
        ];
    }
}
