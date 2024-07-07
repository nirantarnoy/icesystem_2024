<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_lastest".
 *
 * @property string|null $order_date
 * @property string|null $order_no
 * @property float|null $order_total_amt
 * @property int|null $customer_id
 * @property int|null $sale_channel_id
 * @property string|null $code
 * @property string|null $name
 */
class QuerySaleLastest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_lastest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_date'], 'safe'],
            [['order_total_amt'], 'number'],
            [['customer_id', 'sale_channel_id'], 'integer'],
            [['order_no', 'code', 'name'], 'string', 'max' => 255],
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
            'order_total_amt' => 'Order Total Amt',
            'customer_id' => 'Customer ID',
            'sale_channel_id' => 'Sale Channel ID',
            'code' => 'Code',
            'name' => 'Name',
        ];
    }
}
