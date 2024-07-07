<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_saleorder_by_emp".
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
 * @property int|null $employee_id
 * @property string|null $emp_code
 * @property string|null $emp_fname
 * @property string|null $emp_lname
 * @property int|null $emp_position
 */
class QuerySaleorderByEmp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_saleorder_by_emp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'payment_method_id', 'product_id', 'car_ref_id', 'customer_id', 'rt_id', 'employee_id', 'emp_position'], 'integer'],
            [['order_date'], 'safe'],
            [['qty', 'price', 'line_total'], 'number'],
            [['order_no', 'cus_code', 'cus_name', 'route_code', 'car_code', 'car_name', 'emp_code', 'emp_fname', 'emp_lname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => 'เลขที่',
            'order_date' => 'วันที่',
            'payment_method_id' => 'วิธี่ชำระเงิน',
            'product_id' => 'สินค้า',
            'qty' => 'จำนวน',
            'price' => 'ราคา',
            'line_total' => 'รวม',
            'car_ref_id' => 'รถ',
            'customer_id' => 'Customer ID',
            'cus_code' => 'Cus Code',
            'cus_name' => 'Cus Name',
            'rt_id' => 'เส้นทาง',
            'route_code' => 'รหัสเส้นทาง',
            'car_code' => 'Car Code',
            'car_name' => 'Car Name',
            'employee_id' => 'พนักงาน',
            'emp_code' => 'Emp Code',
            'emp_fname' => 'Emp Fname',
            'emp_lname' => 'Emp Lname',
            'emp_position' => 'Emp Position',
        ];
    }
}
