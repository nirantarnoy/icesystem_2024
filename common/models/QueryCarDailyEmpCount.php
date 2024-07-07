<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_car_daily_emp_count".
 *
 * @property int|null $car_id
 * @property string|null $trans_date
 * @property int $emp_qty
 */
class QueryCarDailyEmpCount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_car_daily_emp_count';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['car_id', 'emp_qty'], 'integer'],
            [['trans_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'car_id' => 'Car ID',
            'trans_date' => 'Trans Date',
            'emp_qty' => 'Emp Qty',
        ];
    }
}
