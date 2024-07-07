<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_order_stock_product_price".
 *
 * @property int|null $product_id
 * @property float|null $qty
 * @property float|null $avl_qty
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int $cus_id
 * @property float|null $sale_price
 * @property int|null $delivery_route_id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $photo
 * @property string|null $trans_date
 */
class QuerySaleOrderStockProductPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_order_stock_product_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'company_id', 'branch_id', 'cus_id', 'delivery_route_id'], 'integer'],
            [['qty', 'avl_qty', 'sale_price'], 'number'],
            [['trans_date'], 'safe'],
            [['code', 'name', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'avl_qty' => 'Avl Qty',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'cus_id' => 'Cus ID',
            'sale_price' => 'Sale Price',
            'delivery_route_id' => 'Delivery Route ID',
            'code' => 'Code',
            'name' => 'Name',
            'photo' => 'Photo',
            'trans_date' => 'Trans Date',
        ];
    }
}
