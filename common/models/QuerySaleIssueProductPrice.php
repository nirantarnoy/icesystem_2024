<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_issue_product_price".
 *
 * @property int $id
 * @property int|null $issue_id
 * @property int|null $product_id
 * @property float|null $qty
 * @property int|null $avl_qty
 * @property float|null $sale_price
 * @property int|null $delivery_route_id
 * @property int $cus_id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $photo
 */
class QuerySaleIssueProductPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_issue_product_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'issue_id', 'product_id', 'avl_qty', 'delivery_route_id', 'cus_id'], 'integer'],
            [['qty', 'sale_price'], 'number'],
            [['code', 'name', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'issue_id' => 'Issue ID',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'avl_qty' => 'Avl Qty',
            'sale_price' => 'Sale Price',
            'delivery_route_id' => 'Delivery Route ID',
            'cus_id' => 'Cus ID',
            'code' => 'Code',
            'name' => 'Name',
            'photo' => 'Photo',
        ];
    }
}
