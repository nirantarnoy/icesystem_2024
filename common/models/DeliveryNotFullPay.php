<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $description
 * @property int|null $car_type_id
 * @property string|null $plate_number
 * @property string|null $photo
 * @property int|null $status
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Branch $branch
 * @property Company $company
 */
class DeliveryNotFullPay extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'delivery_not_full_pay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['code'], 'unique'],
            [['route_id'], 'integer'],
            [['trans_date'], 'safe'],
            [['cash_transfer_amount','not_full_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'route_id' => Yii::t('app', 'สายส่ง'),
            'trans_date' => Yii::t('app', 'วันที่'),
            'cash_transfer_amount' => Yii::t('app', 'เงินสดโอน'),
            'not_full_amount' => Yii::t('app', 'เงินขาด'),
        ];
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery
     */
}
