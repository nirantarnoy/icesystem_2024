<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_pos_pay_summary".
 *
 * @property int|null $order_id
 * @property int|null $customer_id
 * @property int|null $payment_method_id
 * @property float|null $line_total
 * @property string|null $order_date
 * @property float|null $payment_amount
 * @property float|null $remain_amount
 * @property int|null $pay_type
 * @property int|null $status
 */
class QuerySalePosPaySummary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_pos_pay_summary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'customer_id', 'payment_method_id', 'pay_type', 'status'], 'integer'],
            [['line_total', 'payment_amount', 'remain_amount'], 'number'],
            [['order_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'customer_id' => 'Customer ID',
            'payment_method_id' => 'Payment Method ID',
            'line_total' => 'Line Total',
            'order_date' => 'Order Date',
            'payment_amount' => 'Payment Amount',
            'remain_amount' => 'Remain Amount',
            'pay_type' => 'Pay Type',
            'status' => 'Status',
        ];
    }
}
