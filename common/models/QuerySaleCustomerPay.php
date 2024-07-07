<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_customer_pay".
 *
 * @property int|null $customer_id
 * @property string|null $payment_date
 * @property int|null $order_id
 * @property int|null $payment_method_id
 * @property float|null $payment_amount
 * @property string|null $doc
 * @property int|null $status
 * @property string|null $order_no
 */
class QuerySaleCustomerPay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_customer_pay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'order_id', 'payment_method_id', 'status'], 'integer'],
            [['payment_date'], 'safe'],
            [['payment_amount'], 'number'],
            [['doc', 'order_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'payment_date' => 'Payment Date',
            'order_id' => 'Order ID',
            'payment_method_id' => 'Payment Method ID',
            'payment_amount' => 'Payment Amount',
            'doc' => 'Doc',
            'status' => 'Status',
            'order_no' => 'Order No',
        ];
    }
}
