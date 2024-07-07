<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_trans".
 *
 * @property int $id
 * @property string|null $trans_no
 * @property string|null $trans_date
 * @property int|null $order_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class PaymentTrans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_trans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date'], 'safe'],
            [['order_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by','company_id','branch_id'], 'integer'],
            [['trans_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trans_no' => 'Trans No',
            'trans_date' => 'Trans Date',
            'order_id' => 'Order ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
