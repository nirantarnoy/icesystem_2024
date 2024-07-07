<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transaction_pos_sale".
 *
 * @property int $id
 * @property string|null $trans_date
 * @property int|null $customer_id
 * @property int|null $customer_type_id
 * @property int|null $product_id
 * @property float|null $credit_qty
 * @property float|null $cash_qty
 * @property float|null $credit_amount
 * @property float|null $cash_amount
 * @property float|null $cash_receive
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $created_at
 */
class TransactionPosSale extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction_pos_sale';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date'], 'safe'],
            [['customer_id', 'customer_type_id', 'product_id', 'company_id', 'branch_id', 'created_at'], 'integer'],
            [['credit_qty', 'cash_qty', 'credit_amount', 'cash_amount', 'cash_receive'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trans_date' => 'Trans Date',
            'customer_id' => 'Customer ID',
            'customer_type_id' => 'Customer Type ID',
            'product_id' => 'Product ID',
            'credit_qty' => 'Credit Qty',
            'cash_qty' => 'Cash Qty',
            'credit_amount' => 'Credit Amount',
            'cash_amount' => 'Cash Amount',
            'cash_receive' => 'Cash Receive',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'created_at' => 'Created At',
        ];
    }
}
