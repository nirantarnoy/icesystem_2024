<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_pos_pay".
 *
 * @property int|null $sale_channel_id
 * @property string|null $payment_date
 * @property float|null $payment_amount
 * @property string|null $code
 * @property string|null $name
 */
class QuerySalePosPay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_pos_pay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_channel_id'], 'integer'],
            [['payment_date'], 'safe'],
            [['payment_amount'], 'number'],
            [['code', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sale_channel_id' => 'Sale Channel ID',
            'payment_date' => 'Payment Date',
            'payment_amount' => 'Payment Amount',
            'code' => 'Code',
            'name' => 'Name',
        ];
    }
}
