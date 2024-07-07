<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_saleorder_by_route_daily".
 *
 * @property string|null $order_date
 * @property string|null $route_code
 * @property string|null $car_code
 * @property string|null $car_name
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $sale_channel_id
 * @property int|null $type_id
 * @property int|null $status
 */
class QuerySaleorderByRouteDaily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_saleorder_by_route_daily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_date'], 'safe'],
            [['company_id', 'branch_id', 'sale_channel_id', 'type_id', 'status','route_id'], 'integer'],
            [['route_code', 'car_code', 'car_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_date' => 'วันที่ขาย',
            'route_code' => 'สายส่ง',
            'car_code' => 'รหัสรถ',
            'car_name' => 'ชื่อรถ',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'sale_channel_id' => 'Sale Channel ID',
            'type_id' => 'Type ID',
            'status' => 'สถานะ',
        ];
    }
}
