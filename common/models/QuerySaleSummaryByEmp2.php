<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_summary_by_emp2".
 *
 * @property int|null $order_channel_id
 * @property string|null $route_code
 * @property int|null $emp_id
 * @property string|null $fname
 * @property string|null $lname
 * @property float|null $Cash
 * @property float|null $Credit
 * @property float|null $1
 * @property float|null $2
 * @property float|null $3
 * @property float|null $4
 * @property float|null $5
 * @property float|null $6
 * @property float|null $7
 * @property float|null $8
 * @property float|null $9
 * @property float|null $10
 * @property float|null $11
 * @property float|null $12
 * @property float|null $13
 * @property float|null $14
 * @property float|null $15
 */
class QuerySaleSummaryByEmp2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_summary_by_emp2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_channel_id', 'emp_id'], 'integer'],
            [['Cash', 'Credit', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15'], 'number'],
            [['route_code', 'fname', 'lname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_channel_id' => 'Order Channel ID',
            'route_code' => 'Route Code',
            'emp_id' => 'Emp ID',
            'fname' => 'Fname',
            'lname' => 'Lname',
            'Cash' => 'Cash',
            'Credit' => 'Credit',
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
            '11' => '11',
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
        ];
    }
}
