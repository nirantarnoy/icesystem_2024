<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_issue".
 *
 * @property int $id
 * @property string|null $journal_no
 * @property string|null $trans_date
 * @property int|null $status
 * @property int|null $car_ref_id
 * @property int|null $delivery_route_id
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $reason_id
 * @property int|null $user_confirm
 * @property int|null $product_id
 * @property int|null $warehouse_id
 * @property int|null $location_id
 * @property float|null $qty
 * @property int|null $line_status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int $line_id
 */
class QueryIssue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_issue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'car_ref_id', 'delivery_route_id', 'company_id', 'branch_id', 'reason_id', 'user_confirm', 'product_id', 'warehouse_id', 'location_id', 'line_status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'line_id'], 'integer'],
            [['trans_date','temp_update'], 'safe'],
            [['qty'], 'number'],
            [['journal_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'journal_no' => 'Journal No',
            'trans_date' => 'Trans Date',
            'status' => 'Status',
            'car_ref_id' => 'Car Ref ID',
            'delivery_route_id' => 'Delivery Route ID',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'reason_id' => 'Reason ID',
            'user_confirm' => 'User Confirm',
            'product_id' => 'Product ID',
            'warehouse_id' => 'Warehouse ID',
            'location_id' => 'Location ID',
            'qty' => 'Qty',
            'line_status' => 'Line Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'line_id' => 'Line ID',
        ];
    }
}
