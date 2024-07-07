<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_daily".
 *
 * @property int $id
 * @property int|null $car_id
 * @property int|null $employee_id
 * @property int|null $is_driver
 * @property int|null $status
 * @property string|null $trans_date
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class CarDaily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'car_daily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['car_id', 'employee_id', 'is_driver', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by','company_id','branch_id'], 'integer'],
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
            'employee_id' => 'Employee ID',
            'is_driver' => 'Is Driver',
            'status' => 'Status',
            'trans_date' => 'Trans Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
