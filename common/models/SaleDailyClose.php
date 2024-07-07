<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_daily_close".
 *
 * @property int $id
 * @property string|null $trans_date
 * @property int|null $user_id
 * @property int|null $status
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class SaleDailyClose extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_daily_close';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date'], 'safe'],
            [['user_id', 'status', 'company_id', 'branch_id', 'created_at', 'updated_at', 'created_by', 'updated_by','order_shift'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trans_date' => 'Trans Date',
            'user_id' => 'User ID',
            'status' => 'Status',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
