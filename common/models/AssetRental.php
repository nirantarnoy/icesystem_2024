<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "asset_rental".
 *
 * @property int $id
 * @property string|null $journal_no
 * @property string|null $trans_date
 * @property int|null $is_paid
 * @property string|null $payment_date
 * @property float|null $payment_amount
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class AssetRental extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asset_rental';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date','use_from','use_to', 'payment_date'], 'safe'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_paid'], 'integer'],
            [['payment_amount'], 'number'],
            [['journal_no','work_name', 'remark'], 'string', 'max' => 255],
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
            'use_from' => 'เริ่มใช้งาน',
            'use_to' => 'ถึง',
            'work_name' => 'ชื่องาน',
            'is_paid' => 'รับชำระเงิน',
            'payment_date' => 'วันที่รับเงิน',
            'payment_amount' => 'จำนวนเงิน',
            'remark' => 'หมายเหตุ',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
