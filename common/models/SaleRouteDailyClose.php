<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_route_daily_close".
 *
 * @property int $id
 * @property string|null $trans_date
 * @property int|null $route_id
 * @property int|null $product_id
 * @property float|null $qty
 * @property int|null $status
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $crated_by
 */
class SaleRouteDailyClose extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_route_daily_close';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date'], 'safe'],
            [['route_id', 'product_id', 'status', 'company_id', 'branch_id', 'crated_by'], 'integer'],
            [['qty'], 'number'],
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
            'route_id' => 'Route ID',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'status' => 'Status',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'crated_by' => 'Crated By',
        ];
    }
}
