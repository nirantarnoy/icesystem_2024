<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_group".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class SaleGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by','company_id','branch_id'], 'integer'],
            [['code', 'name'], 'string', 'max' => 255],
            [['delivery_route_id'],'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => 'รห้ส',
            'name' => 'ชื่อ',
            'status' => 'สถานะ',
            'delivery_route_id' => 'เส้นทาง',
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
