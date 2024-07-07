<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "production_trans".
 *
 * @property int $id
 * @property int|null $machine_detail_id
 * @property int|null $production_ref_id
 * @property int|null $product_id
 * @property string|null $start_date
 * @property string|null $finished_date
 * @property int|null $status
 * @property int|null $emp_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class ProductionTrans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'production_trans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['machine_detail_id', 'production_ref_id', 'product_id', 'status', 'emp_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['start_date', 'finished_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'machine_detail_id' => 'Machine Detail ID',
            'production_ref_id' => 'Production Ref ID',
            'product_id' => 'Product ID',
            'start_date' => 'Start Date',
            'finished_date' => 'Finished Date',
            'status' => 'Status',
            'emp_id' => 'Emp ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
