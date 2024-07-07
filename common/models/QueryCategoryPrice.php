<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_category_price".
 *
 * @property int|null $customer_type_id
 * @property int|null $product_id
 * @property float|null $sale_price
 * @property string|null $code
 * @property string|null $name
 */
class QueryCategoryPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_category_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_type_id', 'product_id','delivery_route_id'], 'integer'],
            [['sale_price'], 'number'],
            [['code', 'name','price_group_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_type_id' => 'Customer Type ID',
            'product_id' => 'Product ID',
            'sale_price' => 'Sale Price',
            'code' => 'Code',
            'name' => 'Name',
        ];
    }
}
