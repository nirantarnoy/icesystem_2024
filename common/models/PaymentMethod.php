<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_method".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $note
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class PaymentMethod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_method';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code','name'],'required'],
            [['code'],'unique'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by','pay_type'], 'integer'],
            [['code', 'name', 'note'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'รห้ส',
            'name' => 'ชื่อ',
            'note' => 'รายละเอียด',
            'status' => 'สถานะ',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
