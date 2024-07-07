<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "daily_count_stock".
 *
 * @property int $id
 * @property string|null $trans_date
 * @property int|null $product_id
 * @property float|null $qty
 * @property int|null $status
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $user_id
 */
class DailyCountStock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'daily_count_stock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date','journal_no'], 'safe'],
            [['product_id', 'status', 'company_id', 'branch_id', 'user_id','warehouse_id','posted'], 'integer'],
            [['qty'], 'number'],
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
            'qty' => 'Qty',
            'status' => 'Status',
            'warehouse_id'=>'Warehouse ID',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'user_id' => 'User ID',
        ];
    }
}
