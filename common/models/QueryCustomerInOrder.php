<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_customer_in_order".
 *
 * @property int|null $order_id
 * @property int|null $customer_id
 */
class QueryCustomerInOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_customer_in_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'customer_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'customer_id' => 'Customer ID',
        ];
    }
}
