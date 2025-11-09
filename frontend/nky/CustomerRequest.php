<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_request".
 *
 * @property int $id
 * @property string|null $journal_no
 * @property string|null $trans_date
 * @property int|null $customer_ref_id
 * @property string|null $customer_name
 * @property float|null $age
 * @property string|null $idcard_no
 * @property string|null $address
 * @property int|null $moo
 * @property int|null $district_id
 * @property int|null $city_id
 * @property int|null $province_id
 * @property string|null $phone
 * @property string|null $company_name
 * @property int|null $route_id
 * @property int|null $route_num
 * @property string|null $start_date
 * @property string|null $sale_price
 * @property string|null $remark
 * @property int|null $payment_method_id
 * @property string|null $account_no
 * @property int|null $credit_term
 * @property string|null $account_credit_no
 * @property int|null $after_invoice_day
 * @property int|null $user_box
 * @property int|null $marget_emp_id
 * @property string|null $market_emp_date
 * @property int|null $is_approve
 * @property int|null $approve_emp_id
 * @property string|null $approve_date
 * @property int|null $is_shop_place
 * @property int|null $emp_operate_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class CustomerRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_name','sale_price','idcard_no','company_name','address','route_num','route_id','age','phone','start_date','province_id','city_id','district_id','moo'], 'required'],
            [['trans_date', 'start_date', 'market_emp_date', 'approve_date'], 'safe'],
            [['customer_ref_id', 'moo', 'district_id', 'city_id', 'province_id', 'route_id', 'route_num', 'payment_method_id', 'credit_term', 'after_invoice_day', 'user_box', 'marget_emp_id', 'is_approve', 'approve_emp_id', 'is_shop_place', 'emp_operate_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['age'], 'number'],
            [['journal_no', 'customer_name', 'idcard_no', 'address', 'phone', 'company_name', 'sale_price', 'remark', 'account_no', 'account_credit_no','use_box_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'journal_no' => 'เลขที่',
            'trans_date' => 'วันที่',
            'customer_ref_id' => 'รหัสลูกค้า',
            'customer_name' => 'ชื่อลูกค้า',
            'age' => 'อายุ',
            'idcard_no' => 'บัตรประชาชนเลขที่',
            'address' => 'ที่อยู่',
            'moo' => 'หมู่ที่',
            'district_id' => 'ตำบล',
            'city_id' => 'อำเภอ',
            'province_id' => 'จังหวัด',
            'phone' => 'เบอร์โทร',
            'company_name' => 'ชื่อกิจการ',
            'route_id' => 'สายส่ง',
            'route_num' => 'ลำดับการส่ง',
            'start_date' => 'วันที่เริ่มส่ง',
            'sale_price' => 'ราคาขาย',
            'remark' => 'หมายเหตุ',
            'payment_method_id' => 'ประเภทการขาย',
            'account_no' => 'บัญชีเงินสด',
            'credit_term' => 'จำนวนวันเครดิต',
            'account_credit_no' => 'บัญชีเครดิต',
            'after_invoice_day' => 'หลังรับวางบิล',
            'user_box' => 'ใช้ถัง',
            'marget_emp_id' => 'เจ้าหน้าที่ตลาด',
            'market_emp_date' => 'วันที่ตลาด',
            'is_approve' => 'สถานะอนุมัติ',
            'approve_emp_id' => 'อนุมัติโดย',
            'approve_date' => 'วันที่อนุมัติ',
            'is_shop_place' => 'สถานที่เปิดร้าน',
            'emp_operate_id' => 'เจ้าหน้าที่ธุรการ',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'use_box_description' => 'รายละเอียดใช้ถัง',
        ];
    }
}
