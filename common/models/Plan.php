<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plan".
 *
 * @property int $id
 * @property string|null $journal_no
 * @property string|null $trans_date
 * @property int|null $customer_id
 * @property int|null $route_id
 * @property string|null $description
 * @property int|null $status
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class Plan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date','status'], 'safe'],
            [['customer_id', 'route_id',  'company_id', 'branch_id', 'created_at', 'created_by', 'updated_at', 'updated_by','car_id'], 'integer'],
            [['journal_no', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'journal_no' => 'เลขที่',
            'trans_date' => 'วันที่',
            'customer_id' => 'ลูกค้า',
            'route_id' => 'สายส่ง',
            'description' => 'หมายเหตุ',
            'status' => 'สถานะ',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
