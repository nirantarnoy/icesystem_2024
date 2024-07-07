<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "journal_issue_line".
 *
 * @property int $id
 * @property int|null $issue_id
 * @property int|null $product_id
 * @property int|null $warehouse_id
 * @property int|null $location_id
 * @property float|null $qty
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class JournalIssueLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'journal_issue_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['issue_id', 'product_id', 'warehouse_id', 'location_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['qty','avl_qty','origin_qty'], 'number'],
            [['sale_price'], 'number'],
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
            'product_id' => 'Product ID',
            'warehouse_id' => 'Warehouse ID',
            'location_id' => 'Location ID',
            'qty' => 'Qty',
            'avl_qty' => 'Available Qty',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
