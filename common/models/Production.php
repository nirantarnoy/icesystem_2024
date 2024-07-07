<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "production".
 *
 * @property int $id
 * @property string|null $prod_no
 * @property string|null $prod_date
 * @property int|null $plan_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $delivery_route_id
 */
class Production extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'production';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prod_date'], 'safe'],
            [['plan_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'company_id', 'branch_id', 'delivery_route_id','product_id'], 'integer'],
            [['qty','remain_qty'],'number'],
            [['prod_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prod_no' => 'ใบสั่งผลิต',
            'prod_date' => 'วันที่',
            'plan_id' => 'แผนผลิต',
            'qty' => 'จำนวนสั่ง',
            'remain_qty' => 'คงค้าง',
            'status' => 'สถานะ',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'delivery_route_id' => 'สายส่ง',
        ];
    }
}
