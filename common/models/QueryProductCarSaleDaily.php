<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_product_car_sale_daily".
 *
 * @property string|null $order_date
 * @property int|null $product_id
 */
class QueryProductCarSaleDaily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_product_car_sale_daily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_date'], 'safe'],
            [['product_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_date' => 'Order Date',
            'product_id' => 'Product ID',
        ];
    }
}
