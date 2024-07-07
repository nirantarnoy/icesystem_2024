<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transaction_car_sale".
 *
 * @property int $id
 * @property string|null $trans_date
 * @property int|null $route_id
 * @property int|null $product_id
 * @property float|null $credit_qty
 * @property float|null $cash_qty
 * @property float|null $credit_amount
 * @property float|null $cash_amount
 * @property float|null $cash_receive
 */
class TransactionCarSale extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction_car_sale';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date'], 'safe'],
            [['route_id', 'product_id'], 'integer'],
            [['credit_qty', 'cash_qty', 'credit_amount', 'cash_amount', 'cash_receive','free_qty','receive_cash','receive_transter','return_qty'], 'number'],
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
            'route_id' => 'Route ID',
            'product_id' => 'Product ID',
            'credit_qty' => 'Credit Qty',
            'cash_qty' => 'Cash Qty',
            'credit_amount' => 'Credit Amount',
            'cash_amount' => 'Cash Amount',
            'cash_receive' => 'Cash Receive',
        ];
    }
}
