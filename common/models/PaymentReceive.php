<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_receive".
 *
 * @property int $id
 * @property string|null $trans_date
 * @property string|null $journal_no
 * @property int|null $customer_id
 * @property int|null $created_at
 * @property int|null $crated_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class PaymentReceive extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_receive';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date'], 'safe'],
            [['customer_id', 'created_at', 'crated_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['journal_no','slip_doc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trans_date' => 'วันที่รับชำระ',
            'journal_no' => 'เลขที่',
            'customer_id' => 'ลูกค้า',
            'created_at' => 'Created At',
            'crated_by' => 'Crated By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }
}
