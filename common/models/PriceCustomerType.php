<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "price_customer_type".
 *
 * @property int $id
 * @property int|null $price_group_id
 * @property int|null $customer_type_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class PriceCustomerType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'price_customer_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price_group_id', 'customer_type_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'price_group_id' => Yii::t('app', 'Price Group ID'),
            'customer_type_id' => Yii::t('app', 'Customer Type ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
