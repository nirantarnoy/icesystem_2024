<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $engname
 * @property string|null $taxid
 * @property string|null $logo
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $tenant_id
 * @property int|null $status
 *
 * @property Addressbook[] $addressbooks
 * @property Branch[] $branches
 * @property Contacts[] $contacts
 * @property CustomerGroup[] $customerGroups
 * @property DeliveryRoute[] $deliveryRoutes
 * @property Employee[] $employees
 * @property ProductGroup[] $productGroups
 * @property ProductType[] $productTypes
 * @property StandardPrice[] $standardPrices
 * @property Unit[] $units
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'tenant_id', 'status'], 'integer'],
            [['code', 'name', 'engname', 'taxid', 'logo','address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'รหัส'),
            'name' => Yii::t('app', 'ชื่อ'),
            'engname' => Yii::t('app', 'ชื่อภาษาอังกฤษ'),
            'taxid' => Yii::t('app', 'เลขที่เสียภาษี'),
            'logo' => Yii::t('app', 'Logo'),
            'address' => Yii::t('app', 'ที่อยู่'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'tenant_id' => Yii::t('app', 'Tenant ID'),
            'status' => Yii::t('app', 'สถานะ'),
        ];
    }

    /**
     * Gets query for [[Addressbooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddressbooks()
    {
        return $this->hasMany(Addressbook::className(), ['company_id' => 'id']);
    }

    /**
     * Gets query for [[Branches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['company_id' => 'id']);
    }

    /**
     * Gets query for [[Contacts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contacts::className(), ['company_id' => 'id']);
    }

    /**
     * Gets query for [[CustomerGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerGroups()
    {
        return $this->hasMany(CustomerGroup::className(), ['company_id' => 'id']);
    }

    /**
     * Gets query for [[DeliveryRoutes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryRoutes()
    {
        return $this->hasMany(DeliveryRoute::className(), ['company_id' => 'id']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['company_id' => 'id']);
    }

    /**
     * Gets query for [[ProductGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductGroups()
    {
        return $this->hasMany(ProductGroup::className(), ['company_id' => 'id']);
    }

    /**
     * Gets query for [[ProductTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypes()
    {
        return $this->hasMany(ProductType::className(), ['company_id' => 'id']);
    }

    /**
     * Gets query for [[StandardPrices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStandardPrices()
    {
        return $this->hasMany(StandardPrice::className(), ['company_id' => 'id']);
    }

    /**
     * Gets query for [[Units]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasMany(Unit::className(), ['company_id' => 'id']);
    }
}
