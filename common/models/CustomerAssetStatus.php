<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_asset_status".
 *
 * @property int $id
 * @property int|null $cus_asset_id
 * @property string|null $photo
 * @property string|null $description
 * @property string|null $trans_date
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class CustomerAssetStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_asset_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cus_asset_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by','customer_id','company_id','branch_id'], 'integer'],
            [['trans_date'], 'safe'],
            [['photo', 'description','latlong'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cus_asset_id' => 'Cus Asset ID',
            'photo' => 'Photo',
            'description' => 'Description',
            'trans_date' => 'Trans Date',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
