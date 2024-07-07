<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_payment_receive".
 *
 * @property int $id
 * @property string|null $trans_date
 * @property string|null $journal_no
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $customer_id
 * @property string|null $customer_code
 * @property string|null $customer_name
 * @property int|null $line_id
 * @property string|null $order_no
 * @property float|null $payment_amount
 * @property int|null $payment_channel_id
 * @property int|null $payment_method_id
 * @property int|null $order_id
 */
class QueryPaymentReceive extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_payment_receive';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'branch_id', 'customer_id', 'line_id', 'payment_channel_id', 'payment_method_id', 'order_id'], 'integer'],
            [['trans_date'], 'safe'],
            [['payment_amount'], 'number'],
            [['journal_no', 'customer_code', 'customer_name', 'order_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trans_date' => 'วันที่',
            'journal_no' => 'เลขที่',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'customer_id' => 'Customer ID',
            'customer_code' => 'รหัสลูกค้า',
            'customer_name' => 'ชื่อลูกค้า',
            'line_id' => 'Line ID',
            'order_no' => 'เลขที่อ้างอิง',
            'payment_amount' => 'จำนวน',
            'payment_channel_id' => 'ช่องทางชำระ',
            'payment_method_id' => 'Payment Method ID',
            'order_id' => 'Order ID',
        ];
    }
}
