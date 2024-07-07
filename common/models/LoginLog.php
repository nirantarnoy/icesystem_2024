<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "login_log".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $login_date
 * @property string|null $logout_date
 */
class LoginLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'login_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id','status'], 'integer'],
            [['login_date', 'logout_date'], 'safe'],
            [['ip'],'string']
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
            'status' => 'Status',
            'ip' => 'IP',
            'login_date' => 'Login Date',
            'logout_date' => 'Logout Date',
        ];
    }
}
