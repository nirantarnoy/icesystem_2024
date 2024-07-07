<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_stock".
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $issue_id
 * @property int|null $product_id
 * @property int|null $qty
 * @property int|null $used_qty
 * @property int|null $avl_qty
 */
class OrderStock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_stock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'issue_id', 'product_id', 'qty', 'used_qty', 'avl_qty','company_id','branch_id','route_id'], 'integer'],
            [['trans_date'],'safe']
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
            'issue_id' => 'Issue ID',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'used_qty' => 'Used Qty',
            'avl_qty' => 'Avl Qty',
        ];
    }
}
