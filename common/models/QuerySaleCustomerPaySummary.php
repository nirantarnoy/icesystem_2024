<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_customer_pay_summary".
 *
 * @property int|null $order_ref_id
 * @property float|null $payment_amount
 * @property int|null $pay_type
 * @property int|null $customer_id
 * @property int|null $payment_type_id
 */
class QuerySaleCustomerPaySummary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_customer_pay_summary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_ref_id', 'pay_type', 'customer_id', 'payment_type_id'], 'integer'],
            [['payment_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_ref_id' => 'Order Ref ID',
            'payment_amount' => 'Payment Amount',
            'pay_type' => 'Pay Type',
            'customer_id' => 'Customer ID',
            'payment_type_id' => 'Payment Type ID',
        ];
    }
}
