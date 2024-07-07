<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_finished".
 *
 * @property int $id
 * @property string|null $order_no
 * @property string|null $order_date
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $product_id
 * @property float|null $qty
 * @property float|null $sale_qty
 * @property float|null $avl_qty
 * @property int|null $route_id
 * @property string|null $route_name
 */
class QuerySaleFinished extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_finished';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'branch_id', 'product_id', 'route_id'], 'integer'],
            [['order_date'], 'safe'],
            [['qty', 'sale_qty', 'avl_qty'], 'number'],
            [['order_no', 'route_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => 'ใบขาย',
            'order_date' => 'วันที่',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'product_id' => 'สินค้า',
            'qty' => 'จำนวนเบิก',
            'sale_qty' => 'จำนวนขาย',
            'avl_qty' => 'คงเหลือ',
            'route_id' => 'สายส่ง',
            'route_name' => 'สายส่ง',
        ];
    }
}
