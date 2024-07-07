<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_product_trans_daily".
 *
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property string|null $date(stock_trans.trans_date)
 * @property int|null $product_id
 * @property string|null $code
 * @property string|null $name
 */
class QueryProductTransDaily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_product_trans_daily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'branch_id', 'product_id'], 'integer'],
            [['date(stock_trans.trans_date)'], 'safe'],
            [['code', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'date(stock_trans.trans_date)' => 'Date(stock Trans Trans Date)',
            'product_id' => 'Product ID',
            'code' => 'Code',
            'name' => 'Name',
        ];
    }
}
