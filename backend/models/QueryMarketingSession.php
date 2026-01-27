<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "query_marketing_session".
 *
 * @property int $id
 * @property int|null $customer_id
 * @property string|null $customer_name
 * @property float|null $check_in_lat
 * @property float|null $check_in_long
 * @property float|null $check_out_lat
 * @property float|null $check_out_long
 * @property string|null $check_in_time
 * @property string|null $check_out_time
 * @property string|null $created_at
 * @property string|null $activity_type
 * @property int|null $route_id
 * @property string|null $route_name
 * @property string|null $shop_name
 * @property string|null $activity_check_in_time
 * @property string|null $activity_check_out_time
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $event_detail
 * @property int|null $rent_borrow_tank
 * @property int|null $collect_tank
 * @property string|null $photo_path
 * @property int|null $user_id
 * @property string|null $username
 * @property string|null $fname
 * @property string|null $lname
 */
class QueryMarketingSession extends \yii\db\ActiveRecord
{
    public $login_date;

    /**
     * {@inheritdoc}
     */
    public static function tableName()

    {
        return 'query_marketing_session';
    }

    /**
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'route_id', 'rent_borrow_tank', 'collect_tank', 'user_id'], 'integer'],
            [['check_in_lat', 'check_in_long', 'check_out_lat', 'check_out_long'], 'number'],
            [['check_in_time', 'check_out_time', 'created_at', 'activity_check_in_time', 'activity_check_out_time', 'start_time', 'end_time'], 'safe'],
            [['customer_name', 'activity_type', 'route_name', 'shop_name', 'event_detail', 'photo_path', 'username', 'fname', 'lname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'customer_name' => 'Customer Name',
            'check_in_lat' => 'Check In Lat',
            'check_in_long' => 'Check In Long',
            'check_out_lat' => 'Check Out Lat',
            'check_out_long' => 'Check Out Long',
            'check_in_time' => 'Check In Time',
            'check_out_time' => 'Check Out Time',
            'created_at' => 'Created At',
            'activity_type' => 'Activity Type',
            'route_id' => 'Route ID',
            'route_name' => 'Route Name',
            'shop_name' => 'Shop Name',
            'activity_check_in_time' => 'Activity Check In Time',
            'activity_check_out_time' => 'Activity Check Out Time',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'event_detail' => 'Event Detail',
            'rent_borrow_tank' => 'Rent Borrow Tank',
            'collect_tank' => 'Collect Tank',
            'photo_path' => 'Photo Path',
            'user_id' => 'User ID',
            'username' => 'Username',
            'fname' => 'First Name',
            'lname' => 'Last Name',
            'login_date' => 'วันที่',
        ];
    }

    public static function getActivities($user_id, $route_id, $date)
    {
        $activities = self::find()
            ->where(['user_id' => $user_id])
            ->andWhere(['DATE(created_at)' => $date])
            ->groupBy('activity_type')
            ->all();

        $has_checkin = false;
        if ($activities) {
            foreach ($activities as $activity) {
                if ($activity->activity_type == 'เช็คอิน') {
                    $has_checkin = true;
                    break;
                }
            }
        }

        if (!$has_checkin) {
            $check = Yii::$app->db->createCommand("SELECT COUNT(*) FROM query_route_customer_checkin WHERE route_id = :route_id AND trans_date = :trans_date")
                ->bindValue(':route_id', $route_id)
                ->bindValue(':trans_date', $date)
                ->queryScalar();

            if ($check > 0) {
                $new_activity = new self();
                $new_activity->activity_type = 'เช็คอิน';
                $activities[] = $new_activity;
            }
        }

        return $activities;
    }
}
