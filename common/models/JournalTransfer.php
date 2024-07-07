<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "journal_transfer".
 *
 * @property int $id
 * @property string|null $journ_no
 * @property string|null $trans_date
 * @property int|null $order_ref_id
 * @property int|null $order_target_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $update_at
 * @property int|null $updated_by
 */
class JournalTransfer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'journal_transfer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['journal_no'],'unique'],
            [['trans_date'], 'safe'],
            [['order_ref_id', 'order_target_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by','from_car_id','to_car_id','from_route_id'],'to_route_id', 'integer'],
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
            'order_ref_id' => 'Order Ref ID',
            'order_target_id' => 'Order Target ID',
            'status' => 'Status',
            'from_car_id' => 'from car',
            'to_car_id' => 'to car',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Update At',
            'updated_by' => 'Updated By',
        ];
    }
}
