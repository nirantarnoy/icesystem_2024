<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_order_daily_product".
 *
 * @property int|null $order_channel_id
 * @property string|null $date(orders.order_date)
 * @property int|null $product_id
 */
class QueryOrderDailyProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_order_daily_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_channel_id', 'product_id'], 'integer'],
            [['date(orders.order_date)'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_channel_id' => 'Order Channel ID',
            'date(orders.order_date)' => 'Date(orders Order Date)',
            'product_id' => 'Product ID',
        ];
    }
}
