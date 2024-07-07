<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_saleorder_by_customer_loan_sum".
 *
 * @property int|null $rt_id
 * @property string|null $route_code
 * @property string|null $car_name
 * @property int|null $customer_id
 * @property string|null $cus_name
 * @property string|null $order_no
 * @property string|null $order_date
 * @property float|null $line_total
 * @property int|null $sale_channel_id
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $customer_type_id
 * @property float|null $payment_amount
 */
class QuerySaleorderByCustomerLoanSum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_saleorder_by_customer_loan_sum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rt_id', 'customer_id', 'sale_channel_id', 'company_id', 'branch_id', 'customer_type_id','car_ref_id'], 'integer'],
            [['order_date'], 'safe'],
            [['line_total', 'payment_amount'], 'number'],
            [['route_code', 'car_name', 'cus_name', 'order_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rt_id' => 'Rt ID',
            'route_code' => 'Route Code',
            'car_name' => 'Car Name',
            'customer_id' => 'Customer ID',
            'cus_name' => 'Cus Name',
            'order_no' => 'Order No',
            'order_date' => 'Order Date',
            'line_total' => 'Line Total',
            'sale_channel_id' => 'Sale Channel ID',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'customer_type_id' => 'Customer Type ID',
            'payment_amount' => 'Payment Amount',
        ];
    }
}
