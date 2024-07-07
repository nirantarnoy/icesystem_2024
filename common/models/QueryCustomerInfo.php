<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_customer_info".
 *
 * @property int $rt_id
 * @property string|null $route_code
 * @property string|null $sale_grp_name
 * @property string|null $cus_name
 * @property string|null $cus_group_name
 * @property string|null $cus_type_name
 * @property int $customer_id
 * @property string|null $branch_no
 */
class QueryCustomerInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_customer_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rt_id', 'customer_id'], 'integer'],
            [['route_code', 'sale_grp_name', 'cus_name', 'cus_group_name', 'cus_type_name', 'branch_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rt_id' => 'Rt ID',
            'route_code' => 'Route Code',
            'sale_grp_name' => 'Sale Grp Name',
            'cus_name' => 'Cus Name',
            'cus_group_name' => 'Cus Group Name',
            'cus_type_name' => 'Cus Type Name',
            'customer_id' => 'Customer ID',
            'branch_no' => 'Branch No',
        ];
    }
}
