<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_line_trans".
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $product_id
 * @property float|null $qty
 * @property float|null $price
 * @property float|null $line_disc_amt
 * @property float|null $line_disc_per
 * @property float|null $line_total
 * @property int|null $status
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $customer_id
 * @property int|null $price_group_id
 * @property string|null $bill_no
 * @property int|null $issue_qty
 * @property int|null $available_qty
 * @property int|null $sale_payment_method_id
 * @property int|null $issue_ref_id
 * @property int|null $is_free
 *
 * @property Branch $branch
 * @property Company $company
 */
class OrderLineTrans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_line_trans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'status', 'company_id', 'branch_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'customer_id', 'price_group_id', 'issue_qty', 'available_qty', 'sale_payment_method_id', 'issue_ref_id', 'is_free'], 'integer'],
            [['qty', 'price', 'line_disc_amt', 'line_disc_per', 'line_total'], 'number'],
            [['bill_no'], 'string', 'max' => 255],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
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
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'price' => 'Price',
            'line_disc_amt' => 'Line Disc Amt',
            'line_disc_per' => 'Line Disc Per',
            'line_total' => 'Line Total',
            'status' => 'Status',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'customer_id' => 'Customer ID',
            'price_group_id' => 'Price Group ID',
            'bill_no' => 'Bill No',
            'issue_qty' => 'Issue Qty',
            'available_qty' => 'Available Qty',
            'sale_payment_method_id' => 'Sale Payment Method ID',
            'issue_ref_id' => 'Issue Ref ID',
            'is_free' => 'Is Free',
        ];
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
