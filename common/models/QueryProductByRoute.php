<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_product_by_route".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property int|null $customer_type_id
 * @property int|null $price_group_id
 * @property int|null $product_id
 * @property int|null $delivery_route_id
 * @property float|null $sale_price
 */
class QueryProductByRoute extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_product_by_route';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'customer_type_id', 'price_group_id', 'product_id', 'delivery_route_id'], 'integer'],
            [['sale_price'], 'number'],
            [['code', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'customer_type_id' => 'Customer Type ID',
            'price_group_id' => 'Price Group ID',
            'product_id' => 'Product ID',
            'delivery_route_id' => 'Delivery Route ID',
            'sale_price' => 'Sale Price',
        ];
    }
}
