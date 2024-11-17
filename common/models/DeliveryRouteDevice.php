<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "delivery_route_device".
 *
 * @property int $id
 * @property int|null $delivery_route_id
 * @property int|null $device_register_id
 */
class DeliveryRouteDevice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'delivery_route_device';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delivery_route_id', 'device_register_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery_route_id' => 'Delivery Route ID',
            'device_register_id' => 'Device Register ID',
        ];
    }
}
