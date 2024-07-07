<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "branch".
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $description
 * @property string|null $logo
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Addressbook[] $addressbooks
 * @property Company $company
 * @property Contacts[] $contacts
 * @property CustomerGroup[] $customerGroups
 * @property DeliveryRoute[] $deliveryRoutes
 * @property Employee[] $employees
 * @property ProductGroup[] $productGroups
 * @property ProductType[] $productTypes
 * @property StandardPrice[] $standardPrices
 * @property Unit[] $units
 */
class Branch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'],'unique'],
            [['company_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['code', 'name', 'description', 'logo','address','line_token','line_token_2'], 'string', 'max' => 255],
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
            'company_id' => Yii::t('app', 'บริษัท'),
            'code' => Yii::t('app', 'รหัส'),
            'name' => Yii::t('app', 'ชื่อสาขา'),
            'description' => Yii::t('app', 'รายละเอียด'),
            'logo' => Yii::t('app', 'Logo'),
            'status' => Yii::t('app', 'สถานะ'),
            'line_token' => Yii::t('app', 'Line Token'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[Addressbooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddressbooks()
    {
        return $this->hasMany(Addressbook::className(), ['branch_id' => 'id']);
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

    /**
     * Gets query for [[Contacts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contacts::className(), ['branch_id' => 'id']);
    }

    /**
     * Gets query for [[CustomerGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerGroups()
    {
        return $this->hasMany(CustomerGroup::className(), ['branch_id' => 'id']);
    }

    /**
     * Gets query for [[DeliveryRoutes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryRoutes()
    {
        return $this->hasMany(DeliveryRoute::className(), ['branch_id' => 'id']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['branch_id' => 'id']);
    }

    /**
     * Gets query for [[ProductGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductGroups()
    {
        return $this->hasMany(ProductGroup::className(), ['branch_id' => 'id']);
    }

    /**
     * Gets query for [[ProductTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypes()
    {
        return $this->hasMany(ProductType::className(), ['branch_id' => 'id']);
    }

    /**
     * Gets query for [[StandardPrices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStandardPrices()
    {
        return $this->hasMany(StandardPrice::className(), ['branch_id' => 'id']);
    }

    /**
     * Gets query for [[Units]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasMany(Unit::className(), ['branch_id' => 'id']);
    }
}
