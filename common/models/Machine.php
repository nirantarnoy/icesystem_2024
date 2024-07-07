<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "machine".
 *
 * @property int $id
 * @property string|null $machine_no
 * @property string|null $name
 * @property string|null $description
 * @property int|null $warehouse_id
 * @property int|null $rows
 * @property int|null $sub_rows
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class Machine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'machine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['warehouse_id', 'rows', 'sub_rows', 'company_id', 'branch_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['machine_no', 'name', 'description'], 'string', 'max' => 255],
            [['status'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'machine_no' => 'Machine No',
            'name' => 'Name',
            'description' => 'Description',
            'warehouse_id' => 'Warehouse ID',
            'rows' => 'Rows',
            'sub_rows' => 'Sub Rows',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
