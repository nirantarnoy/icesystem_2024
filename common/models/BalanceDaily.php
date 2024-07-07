<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "balance_daily".
 *
 * @property int $id
 * @property string|null $trans_date
 * @property int|null $from_user_id
 * @property string|null $sale_close_date
 * @property int|null $product_id
 * @property float|null $balance_qty
 * @property int|null $status
 * @property int|null $company_id
 * @property int|null $branch_id
 */
class BalanceDaily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'balance_daily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date', 'sale_close_date'], 'safe'],
            [['from_user_id', 'product_id', 'status', 'company_id', 'branch_id'], 'integer'],
            [['balance_qty'], 'number'],
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
            'from_user_id' => 'From User ID',
            'sale_close_date' => 'Sale Close Date',
            'product_id' => 'Product ID',
            'balance_qty' => 'Balance Qty',
            'status' => 'Status',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
        ];
    }
}
