<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_receive_line".
 *
 * @property int $id
 * @property int|null $payment_receive_id
 * @property int|null $order_id
 * @property int|null $product_id
 * @property float|null $remain_amount
 * @property float|null $payment_amount
 * @property int|null $status
 */
class PaymentReceiveLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_receive_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_receive_id', 'order_id', 'product_id', 'status','payment_channel_id','payment_type_id','payment_term_id','inv_status'], 'integer'],
            [['remain_amount', 'payment_amount'], 'number'],
            [['doc'],'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment_receive_id' => 'Payment Receive ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'payment_channel_id' => 'ช่องทางชำระเงิน',
            'doc' => 'Doc',
            'remain_amount' => 'Remain Amount',
            'payment_amount' => 'Payment Amount',
            'payment_type_id' => 'Payment type id',
            'payment_term_id' => 'Payment term id',
            'status' => 'Status',
        ];
    }
}
