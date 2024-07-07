<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_car_emp_data".
 *
 * @property string|null $code
 * @property string|null $car_code_
 * @property string|null $car_name_
 * @property int|null $emp_id
 * @property string|null $emp_code_
 * @property string|null $fname
 * @property string|null $lname
 * @property int $id
 * @property int $car_id_
 */
class QueryCarEmpData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_car_emp_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_id', 'id', 'car_id_'], 'integer'],
            [['code', 'car_code_', 'car_name_', 'emp_code_', 'fname', 'lname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'car_code_' => 'Car Code',
            'car_name_' => 'Car Name',
            'emp_id' => 'Emp ID',
            'emp_code_' => 'Emp Code',
            'fname' => 'Fname',
            'lname' => 'Lname',
            'id' => 'ID',
            'car_id_' => 'Car ID',
        ];
    }
}
