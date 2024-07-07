<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_product_by_price_group".
 *
 * @property int|null $price_group_id
 * @property int|null $product_id
 * @property string|null $code
 * @property string|null $name
 * @property float|null $sale_price
 */
class QueryProductByPriceGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_product_by_price_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price_group_id', 'product_id'], 'integer'],
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
            'price_group_id' => 'Price Group ID',
            'product_id' => 'Product ID',
            'code' => 'Code',
            'name' => 'Name',
            'sale_price' => 'Sale Price',
        ];
    }
}
