<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_car_route".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $description
 * @property int|null $delivery_route_id
 * @property string|null $route_code
 * @property string|null $route_name
 */
class QueryCarRoute extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_car_route';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'delivery_route_id'], 'integer'],
            [['code', 'name', 'description', 'route_code', 'route_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'description' => 'Description',
            'delivery_route_id' => 'Delivery Route ID',
            'route_code' => 'Route Code',
            'route_name' => 'Route Name',
        ];
    }
}
