<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_transfer_sale".
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $customer_id
 * @property int|null $product_id
 * @property int|null $qty
 * @property float|null $price
 * @property int|null $transfer_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class OrderTransferSale extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_transfer_sale';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'customer_id', 'product_id', 'qty', 'transfer_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'customer_id' => 'Customer ID',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'price' => 'Price',
            'transfer_id' => 'Transfer ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
