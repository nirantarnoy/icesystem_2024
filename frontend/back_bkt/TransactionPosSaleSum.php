<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transaction_pos_sale_sum".
 *
 * @property int $id
 * @property string|null $trans_date
 * @property int|null $product_id
 * @property float|null $credit_qty
 * @property float|null $cash_qty
 * @property float|null $free_qty
 * @property float|null $balance_in_qty
 * @property float|null $balance_out_qty
 * @property float|null $prodrec_qty
 * @property float|null $reprocess_qty
 * @property float|null $return_qty
 * @property float|null $issue_car_qty
 * @property float|null $issue_transfer_qty
 * @property float|null $issue_refill_qty
 * @property float|null $scrap_qty
 * @property float|null $counting_qty
 * @property int|null $created_at
 */
class TransactionPosSaleSum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction_pos_sale_sum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date','logout_datetime'], 'safe'],
            [['product_id', 'created_at','user_second_id'], 'integer'],
            [['credit_qty', 'cash_qty', 'free_qty', 'balance_in_qty', 'balance_out_qty', 'prodrec_qty', 'reprocess_qty', 'return_qty', 'issue_car_qty', 'issue_transfer_qty', 'issue_refill_qty', 'scrap_qty', 'counting_qty','user_id','login_datetime','transfer_in_qty'], 'number'],
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
            'product_id' => 'Product ID',
            'credit_qty' => 'Credit Qty',
            'cash_qty' => 'Cash Qty',
            'free_qty' => 'Free Qty',
            'balance_in_qty' => 'Balance In Qty',
            'balance_out_qty' => 'Balance Out Qty',
            'prodrec_qty' => 'Prodrec Qty',
            'reprocess_qty' => 'Reprocess Qty',
            'return_qty' => 'Return Qty',
            'issue_car_qty' => 'Issue Car Qty',
            'issue_transfer_qty' => 'Issue Transfer Qty',
            'issue_refill_qty' => 'Issue Refill Qty',
            'scrap_qty' => 'Scrap Qty',
            'counting_qty' => 'Counting Qty',
            'created_at' => 'Created At',
        ];
    }
}
