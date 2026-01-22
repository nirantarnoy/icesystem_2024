<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "marketing_activity".
 *
 * @property int $id
 * @property int $session_id เชื่อมกับ marketing_session.id
 * @property string $activity_type ประเภทเมนู เช่น เปิดร้าน, นำสาย, งานบูธ
 * @property string|null $route_name สายส่ง
 * @property string|null $shop_name ชื่อร้าน/ร้าน
 * @property string|null $activity_check_in_time เวลาเข้า (เฉพาะเมนู)
 * @property string|null $activity_check_out_time เวลาออก (เฉพาะเมนู)
 * @property string|null $start_time เวลาเริ่ม (ประชุม)
 * @property string|null $end_time เวลาเลิก (ประชุม)
 * @property string|null $event_detail รายละเอียดงาน/อื่นๆ
 * @property int|null $rent_borrow_tank เช่า-ยืมถัง (0=ไม่, 1=ใช่)
 * @property int|null $collect_tank เก็บถัง (0=ไม่, 1=ใช่)
 * @property string|null $created_at
 *
 * @property MarketingSession $session
 * @property MarketingActivityPhoto[] $marketingActivityPhotos
 */
class MarketingActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'marketing_activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['session_id', 'activity_type'], 'required'],
            [['session_id', 'rent_borrow_tank', 'collect_tank'], 'integer'],
            [['event_detail'], 'string'],
            [['created_at'], 'safe'],
            [['activity_type'], 'string', 'max' => 100],
            [['route_name', 'shop_name'], 'string', 'max' => 255],
            [['activity_check_in_time', 'activity_check_out_time', 'start_time', 'end_time'], 'string', 'max' => 50],
            [['session_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarketingSession::className(), 'targetAttribute' => ['session_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'session_id' => 'Session ID',
            'activity_type' => 'Activity Type',
            'route_name' => 'Route Name',
            'shop_name' => 'Shop Name',
            'activity_check_in_time' => 'Activity Check In Time',
            'activity_check_out_time' => 'Activity Check Out Time',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'event_detail' => 'Event Detail',
            'rent_borrow_tank' => 'Rent Borrow Tank',
            'collect_tank' => 'Collect Tank',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Session]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSession()
    {
        return $this->hasOne(MarketingSession::className(), ['id' => 'session_id']);
    }

    /**
     * Gets query for [[MarketingActivityPhotos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarketingActivityPhotos()
    {
        return $this->hasMany(MarketingActivityPhoto::className(), ['activity_id' => 'id']);
    }
}
