<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_sum".
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $warehouse_id
 * @property int|null $location_id
 * @property string|null $lot_no
 * @property int|null $product_id
 * @property int|null $qty
 * @property int|null $updated_at
 */
class StockSum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock_sum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'branch_id', 'warehouse_id', 'location_id', 'product_id', 'qty', 'updated_at','created_at','route_id'], 'integer'],
            [['lot_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'warehouse_id' => 'คลังสินค้า',
            'location_id' => 'Location ID',
            'lot_no' => 'Lot No',
            'product_id' => 'สินค้า',
            'qty' => 'จำนวน',
            'route_id'=>'สายส่ง',
            'created_at' => 'Created At',
            'updated_at' => 'อัพเดทล่าสุด',
        ];
    }
}
