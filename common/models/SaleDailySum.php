<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_daily_sum".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $total_cash_qty
 * @property int|null $total_credit_qty
 * @property float|null $total_cash_price
 * @property float|null $total_credit_price
 * @property int|null $balance_in
 * @property int|null $total_prod_qty
 * @property int|null $emp_id
 * @property int|null $trans_shift
 * @property string|null $trans_date
 * @property int|null $status
 */
class SaleDailySum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_daily_sum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'total_cash_qty', 'total_credit_qty', 'balance_in','balance_out', 'total_prod_qty', 'emp_id', 'trans_shift', 'status','issue_refill_qty'], 'integer'],
            [['total_cash_price', 'total_credit_price'], 'number'],
            [['trans_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'total_cash_qty' => 'Total Cash Qty',
            'total_credit_qty' => 'Total Credit Qty',
            'total_cash_price' => 'Total Cash Price',
            'total_credit_price' => 'Total Credit Price',
            'balance_in' => 'Balance In',
            'balance_out' => 'Balance Out',
            'total_prod_qty' => 'Total Prod Qty',
            'emp_id' => 'Emp ID',
            'trans_shift' => 'Trans Shift',
            'trans_date' => 'Trans Date',
            'status' => 'Status',
            'issue_refill_qty' => 'Total Refill'
        ];
    }
}
