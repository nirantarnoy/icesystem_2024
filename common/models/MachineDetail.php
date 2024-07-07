<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "machine_detail".
 *
 * @property int $id
 * @property int|null $machine_id
 * @property string|null $loc_name
 * @property int|null $loc_qty
 * @property int|null $status
 * @property int|null $company_id
 * @property int|null $branch_id
 */
class MachineDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'machine_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['machine_id', 'loc_qty', 'status', 'company_id', 'branch_id'], 'integer'],
            [['loc_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'machine_id' => 'Machine ID',
            'loc_name' => 'Loc Name',
            'loc_qty' => 'Loc Qty',
            'status' => 'Status',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
        ];
    }
}
