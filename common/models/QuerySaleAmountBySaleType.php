<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_sale_amount_by_sale_type".
 *
 * @property string|null $order_date
 * @property string|null $sale_channel_type
 * @property float|null $m1
 * @property float|null $m2
 * @property float|null $m3
 * @property float|null $m4
 * @property float|null $m5
 * @property float|null $m6
 * @property float|null $m7
 * @property float|null $m8
 * @property float|null $m9
 * @property float|null $m10
 * @property float|null $m11
 * @property float|null $m12
 */
class QuerySaleAmountBySaleType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_sale_amount_by_sale_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_date'], 'safe'],
            [['m1', 'm2', 'm3', 'm4', 'm5', 'm6', 'm7', 'm8', 'm9', 'm10', 'm11', 'm12'], 'number'],
            [['sale_channel_type'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_date' => 'Order Date',
            'sale_channel_type' => 'Sale Channel Type',
            'm1' => 'M1',
            'm2' => 'M2',
            'm3' => 'M3',
            'm4' => 'M4',
            'm5' => 'M5',
            'm6' => 'M6',
            'm7' => 'M7',
            'm8' => 'M8',
            'm9' => 'M9',
            'm10' => 'M10',
            'm11' => 'M11',
            'm12' => 'M12',
        ];
    }
}
