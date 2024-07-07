<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_balance_out".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $trans_date
 * @property int|null $product_id
 * @property int|null $balance_out
 * @property int|null $created_at
 */
class SaleBalanceOut extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_balance_out';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'balance_out', 'created_at','status'], 'integer'],
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
            'user_id' => 'User ID',
            'trans_date' => 'Trans Date',
            'product_id' => 'Product ID',
            'balance_out' => 'Balance Out',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}
