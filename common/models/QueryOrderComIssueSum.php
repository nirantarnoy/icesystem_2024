<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_order_com_issue_sum".
 *
 * @property int $id
 * @property string|null $order_no
 * @property string|null $order_date
 * @property int|null $product_id
 * @property float|null $qty
 * @property string|null $name
 * @property int|null $issue_id
 * @property string|null $issue_no
 * @property float|null $issue_qty
 */
class QueryOrderComIssueSum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_order_com_issue_sum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'issue_id','company_id','branch_id'], 'integer'],
            [['order_date'], 'safe'],
            [['qty', 'issue_qty'], 'number'],
            [['order_no', 'name', 'issue_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => 'Order No',
            'order_date' => 'Order Date',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'name' => 'Name',
            'issue_id' => 'Issue ID',
            'issue_no' => 'Issue No',
            'issue_qty' => 'Issue Qty',
        ];
    }
}
