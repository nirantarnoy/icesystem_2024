<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plan_line".
 *
 * @property int $id
 * @property int|null $plan_id
 * @property int|null $product_id
 * @property float|null $qty
 * @property int|null $status
 */
class PlanLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plan_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['plan_id', 'product_id', 'status'], 'integer'],
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
            'plan_id' => 'Plan ID',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'status' => 'Status',
        ];
    }
}
