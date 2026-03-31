<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_request_product".
 *
 * @property int $id
 * @property int|null $customer_req_id
 * @property int|null $product_id
 * @property string|null $product_name
 * @property float|null $price
 */
class CustomerRequestProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_request_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_req_id', 'product_id'], 'integer'],
            [['price','qty'], 'number'],
            [['product_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_req_id' => 'Customer Req ID',
            'product_id' => 'Product ID',
            'product_name' => 'Product Name',
            'price' => 'Price',
        ];
    }
}
