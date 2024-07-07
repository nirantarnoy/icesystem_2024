<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_emp".
 *
 * @property int $id
 * @property int|null $car_id
 * @property int|null $emp_id
 * @property int|null $status
 */
class CarEmp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'car_emp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['car_id', 'emp_id', 'status', 'company_id', 'branch_id'], 'integer'],
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
            'emp_id' => 'Emp ID',
            'status' => 'Status',
        ];
    }
}
