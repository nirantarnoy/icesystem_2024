<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_meter_daily".
 *
 * @property int $id
 * @property int|null $car_id
 * @property float|null $before_meter
 * @property float|null $affer_meter
 * @property string|null $trans_date
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class CarMeterDaily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'car_meter_daily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['car_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['before_meter', 'affer_meter'], 'number'],
            [['trans_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'car_id' => 'Car ID',
            'before_meter' => 'Before Meter',
            'affer_meter' => 'Affer Meter',
            'trans_date' => 'Trans Date',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
