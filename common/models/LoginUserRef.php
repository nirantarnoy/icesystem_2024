<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "login_user_ref".
 *
 * @property int $id
 * @property int|null $login_log_cal_id
 * @property int|null $user_id
 */
class LoginUserRef extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'login_user_ref';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login_log_cal_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login_log_cal_id' => 'Login Log Cal ID',
            'user_id' => 'User ID',
        ];
    }
}
