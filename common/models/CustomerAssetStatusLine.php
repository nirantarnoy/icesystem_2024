<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_asset_status_line".
 *
 * @property int $id
 * @property int|null $asset_status_id
 * @property int|null $checklist_id
 * @property int|null $check_status
 */
class CustomerAssetStatusLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_asset_status_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['asset_status_id', 'checklist_id', 'check_status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'asset_status_id' => 'Asset Status ID',
            'checklist_id' => 'Checklist ID',
            'check_status' => 'Check Status',
        ];
    }
}
