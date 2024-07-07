<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "journal_issue".
 *
 * @property int $id
 * @property string|null $journal_no
 * @property string|null $trans_date
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class JournalIssue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'journal_issue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delivery_route_id'], 'required'],
            [['trans_date'], 'safe'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'delivery_route_id', 'car_ref_id', 'order_ref_id', 'reason_id','plan_id','is_for_next_date','trans_ref_id'], 'integer'],
            [['journal_no'], 'string', 'max' => 255],
            [['status', 'user_confirm'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'journal_no' => 'เลขที่ใบเบิก',
            'trans_date' => 'วันที่',
            'delivery_route_id' => 'สายส่ง',
            'order_ref_id' => 'เลขที่ขาย',
            'reason' => 'เหตุผลเบิก',
            'status' => 'สถานะ',
            'plan_id' => 'เลขที่แผน',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
