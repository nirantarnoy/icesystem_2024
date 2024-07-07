<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_customer_price".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property int|null $customer_type_id
 * @property int $cus_id
 * @property string|null $cus_code
 * @property string|null $cus_name
 * @property int|null $product_id
 * @property float|null $sale_price
 */
class QueryCustomerPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_customer_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'customer_type_id', 'cus_id', 'product_id','delivery_route_id'], 'integer'],
            [['sale_price'], 'number'],
            [['code', 'name', 'cus_code', 'cus_name'], 'string', 'max' => 255],
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
            'cus_id' => 'Cus ID',
            'cus_code' => 'Cus Code',
            'cus_name' => 'Cus Name',
            'product_id' => 'Product ID',
            'sale_price' => 'Sale Price',
        ];
    }
}
