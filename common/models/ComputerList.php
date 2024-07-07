<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "computer_list".
 *
 * @property int $id
 * @property string|null $computer_name
 * @property string|null $mac_address
 * @property string|null $ip_address
 */
class ComputerList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'computer_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['computer_name', 'mac_address', 'ip_address'], 'string', 'max' => 255],
            [['userid'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'computer_name' => 'Computer Name',
            'mac_address' => 'Mac Address',
            'ip_address' => 'Ip Address',
            'userid'=>'Users',
        ];
    }
}
