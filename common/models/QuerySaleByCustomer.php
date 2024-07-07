<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_by_customer".
 *
 * @property string|null $order_date
 * @property string|null $order_no
 * @property int|null $customer_id
 * @property int $id
 */
class QuerySaleByCustomer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_by_customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_date'], 'safe'],
            [['customer_id', 'id'], 'integer'],
            [['order_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_date' => 'Order Date',
            'order_no' => 'Order No',
            'customer_id' => 'Customer ID',
            'id' => 'ID',
        ];
    }
}
