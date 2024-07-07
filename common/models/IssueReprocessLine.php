<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "issue_reprocess_line".
 *
 * @property int $id
 * @property int|null $issue_id
 * @property int|null $product_id
 * @property float|null $qty
 * @property int|null $to_warehouse_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class IssueReprocessLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issue_reprocess_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['issue_id', 'product_id', 'to_warehouse_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'to_warehouse_id' => 'To Warehouse ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
