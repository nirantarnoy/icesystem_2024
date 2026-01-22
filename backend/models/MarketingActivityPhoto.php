<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "marketing_activity_photo".
 *
 * @property int $id
 * @property int $activity_id เชื่อมกับ marketing_activity.id
 * @property string $photo_path ชื่อไฟล์หรือ Path รูปภาพ
 * @property string|null $created_at
 *
 * @property MarketingActivity $activity
 */
class MarketingActivityPhoto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'marketing_activity_photo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_id', 'photo_path'], 'required'],
            [['activity_id'], 'integer'],
            [['created_at'], 'safe'],
            [['photo_path'], 'string', 'max' => 255],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarketingActivity::className(), 'targetAttribute' => ['activity_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => 'Activity ID',
            'photo_path' => 'Photo Path',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Activity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(MarketingActivity::className(), ['id' => 'activity_id']);
    }
}
