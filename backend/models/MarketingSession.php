<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "marketing_session".
 *
 * @property int $id
 * @property int|null $user_id ID พนักงาน
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $customer_id ID ลูกค้าที่เลือก
 * @property string|null $customer_name
 * @property float|null $check_in_lat
 * @property float|null $check_in_long
 * @property float|null $check_out_lat
 * @property float|null $check_out_long
 * @property string|null $check_in_time
 * @property string|null $check_out_time
 * @property string|null $created_at
 *
 * @property MarketingActivity[] $marketingActivities
 */
class MarketingSession extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'marketing_session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'company_id', 'branch_id', 'customer_id'], 'integer'],
            [['check_in_lat', 'check_in_long', 'check_out_lat', 'check_out_long'], 'number'],
            [['check_in_time', 'check_out_time', 'created_at'], 'safe'],
            [['customer_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'customer_id' => 'Customer ID',
            'customer_name' => 'Customer Name',
            'check_in_lat' => 'Check In Lat',
            'check_in_long' => 'Check In Long',
            'check_out_lat' => 'Check Out Lat',
            'check_out_long' => 'Check Out Long',
            'check_in_time' => 'Check In Time',
            'check_out_time' => 'Check Out Time',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[MarketingActivities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarketingActivities()
    {
        return $this->hasMany(MarketingActivity::className(), ['session_id' => 'id']);
    }
}
