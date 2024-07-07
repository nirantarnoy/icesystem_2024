<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $fname
 * @property string|null $lname
 * @property int|null $gender
 * @property int|null $position
 * @property int|null $salary_type
 * @property string|null $emp_start
 * @property string|null $description
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
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'],'unique'],
            [['gender', 'position', 'salary_type', 'status', 'company_id', 'branch_id', 'created_at', 'updated_at', 'created_by', 'updated_by','is_com_cal','is_sale_operator'], 'integer'],
            [['emp_start'], 'safe'],
            [['code', 'fname', 'lname', 'description', 'photo'], 'string', 'max' => 255],
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
            'code' => Yii::t('app', 'รหัส'),
            'fname' => Yii::t('app', 'ชื่อ'),
            'lname' => Yii::t('app', 'นามสกุล'),
            'gender' => Yii::t('app', 'เพศ'),
            'position' => Yii::t('app', 'ตำแหน่ง'),
            'salary_type' => Yii::t('app', 'ประเภทเงินเดือน'),
            'emp_start' => Yii::t('app', 'วันที่เริ่มงาน'),
            'description' => Yii::t('app', 'รายละเอียด'),
            'photo' => Yii::t('app', 'Photo'),
            'is_com_cal' => Yii::t('app', 'คิดค่าคอมมิชชั่น'),
            'is_sale_operator' => Yii::t('app', 'พนักงานขาย POS'),
            'status' => Yii::t('app', 'สถานะ'),
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
