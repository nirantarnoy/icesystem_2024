<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_pos_pay_daily".
 *
 * @property int|null $order_ref_id
 * @property int|null $trans_id
 * @property int|null $payment_method_id
 * @property int|null $payment_term_id
 * @property float|null $payment_amount
 * @property string|null $code
 * @property string|null $payment_date
 */
class QuerySalePosPayDaily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_pos_pay_daily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_ref_id', 'trans_id', 'payment_method_id', 'payment_term_id'], 'integer'],
            [['payment_amount'], 'number'],
            [['payment_date'], 'safe'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_ref_id' => 'Order Ref ID',
            'trans_id' => 'Trans ID',
            'payment_method_id' => 'Payment Method ID',
            'payment_term_id' => 'Payment Term ID',
            'payment_amount' => 'Payment Amount',
            'code' => 'Code',
            'payment_date' => 'Payment Date',
        ];
    }
}
