<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "production_line".
 *
 * @property int $id
 * @property int|null $prod_id
 * @property int|null $product_id
 * @property float|null $qty
 * @property float|null $remain_qty
 * @property int|null $status
 */
class ProductionLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'production_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prod_id', 'product_id', 'status'], 'integer'],
            [['qty', 'remain_qty'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prod_id' => 'Prod ID',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'remain_qty' => 'Remain Qty',
            'status' => 'Status',
        ];
    }
}
