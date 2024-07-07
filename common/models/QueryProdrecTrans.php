<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_prodrec_trans".
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property string|null $journal_no
 * @property int|null $product_id
 * @property int|null $warehouse_id
 * @property int|null $qty
 * @property string|null $product_code
 * @property string|null $product_name
 * @property string|null $warehouse_code
 * @property string|null $warehouse_name
 * @property int|null $production_type
 * @property string|null $trans_date
 * @property int|null $created_by
 * @property string $username
 */
class QueryProdrecTrans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_prodrec_trans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'branch_id', 'product_id', 'warehouse_id', 'qty', 'production_type', 'created_by','status'], 'integer'],
            [['trans_date'], 'safe'],
            [['username'], 'required'],
            [['journal_no', 'product_code', 'product_name', 'warehouse_code', 'warehouse_name', 'username'], 'string', 'max' => 255],
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
            'journal_no' => 'Journal No',
            'product_id' => 'Product ID',
            'warehouse_id' => 'Warehouse ID',
            'qty' => 'Qty',
            'product_code' => 'Product Code',
            'product_name' => 'Product Name',
            'warehouse_code' => 'Warehouse Code',
            'warehouse_name' => 'Warehouse Name',
            'production_type' => 'Production Type',
            'trans_date' => 'Trans Date',
            'created_by' => 'Created By',
            'username' => 'Username',
        ];
    }
}
