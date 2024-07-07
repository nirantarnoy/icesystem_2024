<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transform_reserv".
 *
 * @property int $id
 * @property string|null $trans_date
 * @property int|null $product_id
 * @property float|null $qty
 * @property int|null $status
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $user_id
 */
class TransformReserv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transform_reserv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date'], 'safe'],
            [['product_id', 'status', 'company_id', 'branch_id', 'user_id'], 'integer'],
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
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'status' => 'Status',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'user_id' => 'User ID',
        ];
    }
}
