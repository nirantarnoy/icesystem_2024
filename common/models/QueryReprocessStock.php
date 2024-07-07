<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_reprocess_stcok".
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $warehouse_id
 * @property int|null $product_id
 * @property string|null $product_code
 * @property string|null $product_name
 * @property string|null $warehouse_name
 * @property int|null $is_reprocess
 * @property int|null $qty
 */
class QueryReprocessStock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_reprocess_stock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'branch_id', 'warehouse_id', 'product_id', 'is_reprocess', 'qty'], 'integer'],
            [['product_code', 'product_name', 'warehouse_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'warehouse_id' => 'Warehouse ID',
            'product_id' => 'Product ID',
            'product_code' => 'Product Code',
            'product_name' => 'Product Name',
            'warehouse_name' => 'Warehouse Name',
            'is_reprocess' => 'Is Reprocess',
            'qty' => 'Qty',
        ];
    }
}
