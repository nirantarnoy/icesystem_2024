<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_user_daily_login".
 *
 * @property string|null $login_date
 * @property int|null $user_id
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $second_user_id
 */
class QueryUserDailyLogin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_user_daily_login';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login_date'], 'safe'],
            [['user_id', 'company_id', 'branch_id', 'second_user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'login_date' => 'Login Date',
            'user_id' => 'User ID',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'second_user_id' => 'Second User ID',
        ];
    }
}
