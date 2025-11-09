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
class CloseMonthlyQuantity extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'close_monthly_quantity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['code'], 'unique'],
            [['product_id'], 'integer'],
            [['trans_date'], 'safe'],
            [['qty'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'สินค้า'),
            'trans_date' => Yii::t('app', 'วันที่'),
            'qty' => Yii::t('app', 'จำนวน'),
        ];
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery
     */
}
