<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_trans_line".
 *
 * @property int $id
 * @property int|null $trans_id
 * @property int|null $customer_id
 * @property string|null $payment_date
 * @property int|null $payment_method_id
 * @property int|null $payment_term_id
 * @property float|null $payment_amount
 * @property float|null $total_amount
 * @property float|null $change_amount
 * @property string|null $doc
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class PaymentTransLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_trans_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_id', 'customer_id', 'payment_method_id', 'payment_term_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by','order_ref_id','payment_type_id'], 'integer'],
            [['payment_date'], 'safe'],
            [['payment_amount', 'total_amount', 'change_amount'], 'number'],
            [['doc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trans_id' => 'Trans ID',
            'customer_id' => 'Customer ID',
            'payment_date' => 'Payment Date',
            'payment_method_id' => 'Payment Method ID',
            'payment_term_id' => 'Payment Term ID',
            'payment_amount' => 'Payment Amount',
            'total_amount' => 'Total Amount',
            'change_amount' => 'Change Amount',
            'doc' => 'Doc',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
