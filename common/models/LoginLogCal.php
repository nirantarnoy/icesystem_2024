<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "login_log_cal".
 *
 * @property int $id
 * @property string|null $login_date
 * @property int|null $user_id
 * @property string|null $ip
 * @property int|null $status
 * @property int|null $company_id
 * @property int|null $branch_id
 */
class LoginLogCal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'login_log_cal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login_date'], 'safe'],
            [['user_id', 'status', 'company_id', 'branch_id'], 'integer'],
            [['ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login_date' => 'Login Date',
            'user_id' => 'User ID',
            'ip' => 'Ip',
            'status' => 'Status',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
        ];
    }
}
