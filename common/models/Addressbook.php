<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "addressbook".
 *
 * @property int $id
 * @property int|null $address
 * @property string|null $street
 * @property int|null $district_id
 * @property int|null $city_id
 * @property int|null $province_id
 * @property string|null $zipcode
 * @property int|null $address_type_id
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
class Addressbook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'addressbook';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'district_id', 'city_id', 'province_id', 'address_type_id', 'status', 'company_id', 'branch_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['street', 'zipcode'], 'string', 'max' => 255],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'address' => Yii::t('app', 'Address'),
            'street' => Yii::t('app', 'Street'),
            'district_id' => Yii::t('app', 'District ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'province_id' => Yii::t('app', 'Province ID'),
            'zipcode' => Yii::t('app', 'Zipcode'),
            'address_type_id' => Yii::t('app', 'Address Type ID'),
            'status' => Yii::t('app', 'Status'),
            'company_id' => Yii::t('app', 'Company ID'),
            'branch_id' => Yii::t('app', 'Branch ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
