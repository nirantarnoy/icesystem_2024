<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "journal_payment".
 *
 * @property int $id
 * @property string|null $journal_no
 * @property string|null $trans_date
 * @property int|null $order_id
 * @property int|null $payment_method_id
 * @property int|null $payment_term_id
 * @property float|null $total_amount
 * @property float|null $pay_amount
 * @property float|null $change_amount
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class JournalPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'journal_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'payment_method_id', 'payment_term_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['total_amount', 'pay_amount', 'change_amount'], 'number'],
            [['journal_no', 'trans_date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'journal_no' => 'Journal No',
            'trans_date' => 'Trans Date',
            'order_id' => 'Order ID',
            'payment_method_id' => 'Payment Method ID',
            'payment_term_id' => 'Payment Term ID',
            'total_amount' => 'Total Amount',
            'pay_amount' => 'Pay Amount',
            'change_amount' => 'Change Amount',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
