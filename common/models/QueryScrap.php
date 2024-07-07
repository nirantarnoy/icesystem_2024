<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_scrap".
 *
 * @property int $id
 * @property string|null $journal_no
 * @property string|null $trans_date
 * @property int|null $status
 * @property int|null $scrap_type_id
 * @property int|null $prodrec_id
 * @property int|null $product_id
 * @property float|null $qty
 * @property string|null $note
 * @property string|null $code
 * @property string|null $name
 * @property string|null $prod_rec_no
 * @property int|null $created_by
 * @property string $username
 * @property int|null $company_id
 * @property int|null $branch_id
 */
class QueryScrap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_scrap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'scrap_type_id', 'prodrec_id', 'product_id', 'created_by', 'company_id', 'branch_id'], 'integer'],
            [['trans_date'], 'safe'],
            [['qty'], 'number'],
            [['username'], 'required'],
            [['journal_no', 'note', 'code', 'name', 'prod_rec_no', 'username'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'journal_no' => 'Journal No',
            'trans_date' => 'Trans Date',
            'status' => 'Status',
            'scrap_type_id' => 'Scrap Type ID',
            'prodrec_id' => 'Prodrec ID',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'note' => 'Note',
            'code' => 'Code',
            'name' => 'Name',
            'prod_rec_no' => 'Prod Rec No',
            'created_by' => 'Created By',
            'username' => 'Username',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
        ];
    }
}
