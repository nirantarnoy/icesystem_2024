<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_trans_by_emp".
 *
 * @property string|null $order_no
 * @property string|null $order_date
 * @property float|null $vat_amt
 * @property int|null $order_channel_id
 * @property int|null $payment_method_id
 * @property int|null $product_id
 * @property float|null $qty
 * @property float|null $price
 * @property int|null $customer_id
 * @property string|null $route_code
 * @property string|null $sale_grp_name
 * @property string|null $cus_name
 * @property string|null $cus_group_name
 * @property string|null $cus_type_name
 * @property int $car_id_
 * @property string|null $car_code_
 * @property string|null $car_name_
 * @property int|null $emp_id
 * @property string|null $fname
 * @property string|null $lname
 */
class QuerySaleTransByEmp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_trans_by_emp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_date'], 'safe'],
            [['vat_amt', 'qty', 'price'], 'number'],
            [['order_channel_id', 'payment_method_id', 'product_id', 'customer_id', 'car_id_', 'emp_id'], 'integer'],
            [['order_no', 'route_code', 'sale_grp_name', 'cus_name', 'cus_group_name', 'cus_type_name', 'car_code_', 'car_name_', 'fname', 'lname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_no' => 'คำสั่งซื้อ',
            'order_date' => 'วันที่',
            'vat_amt' => 'Vat Amt',
            'order_channel_id' => 'สายส่ง',
            'payment_method_id' => 'วิธีชำระเงิน',
            'product_id' => 'สินค้า',
            'qty' => 'จำนวน',
            'price' => 'ราคา',
            'customer_id' => 'ลูกค้า',
            'route_code' => 'Route Code',
            'sale_grp_name' => 'Sale Grp Name',
            'cus_name' => 'Cus Name',
            'cus_group_name' => 'Cus Group Name',
            'cus_type_name' => 'Cus Type Name',
            'car_id_' => 'Car ID',
            'car_code_' => 'Car Code',
            'car_name_' => 'Car Name',
            'emp_id' => 'พนักงาน',
            'fname' => 'Fname',
            'lname' => 'Lname',
        ];
    }
}
