<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "issue_stock_temp".
 *
 * @property int $id
 * @property int|null $issue_id
 * @property int|null $prodrec_id
 * @property int|null $product_id
 * @property float|null $qty
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $crated_at
 */
class IssueStockTemp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issue_stock_temp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['issue_id', 'prodrec_id', 'product_id', 'status', 'created_by', 'crated_at'], 'integer'],
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
            'issue_id' => 'Issue ID',
            'prodrec_id' => 'Prodrec ID',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'status' => 'Status',
            'created_by' => 'Created By',
            'crated_at' => 'Crated At',
        ];
    }
}
