<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "branch_transfer_line".
 *
 * @property int $id
 * @property int|null $journal_id
 * @property int|null $product_id
 * @property int|null $from_company_id
 * @property int|null $from_branch_id
 * @property int|null $from_warehouse_id
 * @property int|null $from_location_id
 * @property int|null $to_company_id
 * @property int|null $to_branch_id
 * @property int|null $to_warehouse_id
 * @property int|null $to_location_id
 * @property int|null $qty
 * @property int|null $status
 */
class BranchTransferLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branch_transfer_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['journal_id', 'product_id', 'from_company_id', 'from_branch_id', 'from_warehouse_id', 'from_location_id', 'to_company_id', 'to_branch_id', 'to_warehouse_id', 'to_location_id', 'qty', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'journal_id' => 'Journal ID',
            'product_id' => 'Product ID',
            'from_company_id' => 'From Company ID',
            'from_branch_id' => 'From Branch ID',
            'from_warehouse_id' => 'From Warehouse ID',
            'from_location_id' => 'From Location ID',
            'to_company_id' => 'To Company ID',
            'to_branch_id' => 'To Branch ID',
            'to_warehouse_id' => 'To Warehouse ID',
            'to_location_id' => 'To Location ID',
            'qty' => 'Qty',
            'status' => 'Status',
        ];
    }
}
