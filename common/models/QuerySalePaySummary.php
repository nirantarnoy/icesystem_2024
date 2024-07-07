<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_pay_summary".
 *
 * @property int|null $customer_id
 * @property int|null $order_id
 * @property float|null $line_total
 * @property string|null $order_date
 * @property float|null $payment_amount
 */
class QuerySalePaySummary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_pay_summary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'order_id'], 'integer'],
            [['line_total', 'payment_amount'], 'number'],
            [['order_date','remain_amount'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'order_id' => 'Order ID',
            'line_total' => 'Line Total',
            'order_date' => 'Order Date',
            'payment_amount' => 'Payment Amount',
        ];
    }
}
