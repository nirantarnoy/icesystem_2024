<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_plan_by_route".
 *
 * @property int $id
 * @property string|null $trans_date
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $product_id
 * @property string|null $code
 * @property string|null $name
 * @property float|null $qty
 * @property int|null $route_id
 * @property string|null $route_name
 * @property string|null $trans_date2
 * @property int|null $car_id
 * @property string|null $car_name
 * @property int|null $created_by
 * @property string|null $fname
 * @property string|null $lname
 */
class QueryPlanByRoute extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_plan_by_route';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'branch_id', 'product_id', 'route_id', 'car_id', 'created_by'], 'integer'],
            [['trans_date', 'trans_date2'], 'safe'],
            [['qty'], 'number'],
            [['code', 'name', 'route_name', 'car_name', 'fname', 'lname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trans_date' => 'Trans Date',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'product_id' => 'Product ID',
            'code' => 'Code',
            'name' => 'Name',
            'qty' => 'Qty',
            'route_id' => 'Route ID',
            'route_name' => 'Route Name',
            'trans_date2' => 'Trans Date 2',
            'car_id' => 'Car ID',
            'car_name' => 'Car Name',
            'created_by' => 'Created By',
            'fname' => 'First Name',
            'lname' => 'Last Name',
        ];
    }
}
