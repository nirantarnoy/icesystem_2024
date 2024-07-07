<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_saleorder_by_route".
 *
 * @property int $id
 * @property string|null $order_no
 * @property string|null $order_date
 * @property int|null $payment_method_id
 * @property int|null $product_id
 * @property float|null $qty
 * @property float|null $price
 * @property float|null $line_total
 * @property int|null $car_ref_id
 * @property int|null $customer_id
 * @property string|null $cus_code
 * @property string|null $cus_name
 * @property int|null $rt_id
 * @property string|null $route_code
 * @property string|null $car_code
 * @property string|null $car_name
 */
class QuerySaleorderByRoute extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_saleorder_by_route';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'payment_method_id', 'product_id', 'car_ref_id', 'customer_id', 'rt_id','company_id','branch_id'], 'integer'],
            [['order_date'], 'safe'],
            [['qty', 'price', 'line_total'], 'number'],
            [['order_no', 'cus_code', 'cus_name', 'route_code', 'car_code', 'car_name','prod_code','prod_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => 'คำสั่งซื้อ',
            'order_date' => 'วันที่',
            'payment_method_id' => 'วิธีชำระเงิน',
            'product_id' => 'สินค้า',
            'qty' => 'จำนวน',
            'price' => 'ราคา',
            'line_total' => 'รวม',
            'car_ref_id' => 'รถ',
            'customer_id' => 'ลูกค้า',
            'cus_code' => 'Cus Code',
            'cus_name' => 'Cus Name',
            'rt_id' => 'เส้นทาง',
            'route_code' => 'Route Code',
            'car_code' => 'Car Code',
            'car_name' => 'Car Name',
        ];
    }
}
