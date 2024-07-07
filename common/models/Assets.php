<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "assets".
 *
 * @property int $id
 * @property string|null $asset_no
 * @property string|null $asset_name
 * @property string|null $description
 * @property int|null $status
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class Assets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'company_id', 'branch_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['asset_no', 'asset_name', 'description'], 'string', 'max' => 255],
            [['rent_price'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'asset_no' => 'Asset No',
            'asset_name' => 'Asset Name',
            'description' => 'Description',
            'status' => 'Status',
            'rent_price' => 'Rent Price',
            'company_id' => 'Company ID',
            'branch_id' => 'Branch ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
