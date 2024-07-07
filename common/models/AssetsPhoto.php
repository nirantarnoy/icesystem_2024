<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "assets_photo".
 *
 * @property int $id
 * @property int|null $asset_id
 * @property string|null $photo
 * @property string|null $file_ext
 * @property int|null $status
 */
class AssetsPhoto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assets_photo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['asset_id', 'status','in_use'], 'integer'],
            [['photo', 'file_ext'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'asset_id' => 'Asset ID',
            'photo' => 'Photo',
            'file_ext' => 'File Ext',
            'status' => 'Status',
            'in_use' => 'In Use',
        ];
    }
}
