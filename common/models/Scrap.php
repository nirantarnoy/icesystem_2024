<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "scrap".
 *
 * @property int $id
 * @property string|null $journal_no
 * @property string|null $trans_date
 * @property int|null $status
 * @property int|null $scrap_type_id
 * @property int|null $prodrec_id
 * @property int|null $created_by
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Scrap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'scrap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date'], 'safe'],
            [['status', 'scrap_type_id', 'prodrec_id', 'created_by', 'created_at', 'updated_at','company_id','branch_id','order_id'], 'integer'],
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
            'journal_no' => 'เลขที่',
            'trans_date' => 'วันที่',
            'status' => 'สถานะ',
            'scrap_type_id' => 'ประเภท',
            'prodrec_id' => 'เลขที่ใบรับเข้า',
            'order_id'=>'ใบขาย',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
