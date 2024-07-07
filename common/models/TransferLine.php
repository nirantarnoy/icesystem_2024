<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transfer_line".
 *
 * @property int $id
 * @property int|null $transfer_id
 * @property int|null $product_id
 * @property float|null $sale_price
 * @property int|null $qty
 * @property int|null $created_at
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class TransferLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transfer_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transfer_id', 'product_id', 'qty', 'created_at', 'status', 'created_by', 'updated_at', 'updated_by','avl_qty'], 'integer'],
            [['sale_price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transfer_id' => 'Transfer ID',
            'product_id' => 'Product ID',
            'sale_price' => 'Sale Price',
            'qty' => 'Qty',
            'avl_qty' => 'Avl Qty',
            'created_at' => 'Created At',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
