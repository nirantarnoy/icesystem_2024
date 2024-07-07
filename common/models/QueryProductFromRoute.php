<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_product_from_route".
 *
 * @property int|null $delivery_route_id
 * @property int|null $product_id
 * @property string|null $code
 * @property float|null $sale_price
 */
class QueryProductFromRoute extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_product_from_route';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delivery_route_id', 'product_id'], 'integer'],
            [['sale_price'], 'number'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'delivery_route_id' => 'Delivery Route ID',
            'product_id' => 'Product ID',
            'code' => 'Code',
            'sale_price' => 'Sale Price',
        ];
    }
}
