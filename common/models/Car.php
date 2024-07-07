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
class Car extends \yii\db\ActiveRecord
{
    public $emp_id;

    public static function tableName()
    {
        return 'car';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           // [['code'], 'unique'],
            [['car_type_id', 'status', 'company_id', 'branch_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['code', 'name', 'description', 'plate_number', 'photo'], 'string', 'max' => 255],
            [['emp_id'], 'safe'],
            [['meter','total_meter'],'number'],
            [['sale_group_id','sale_com_id','sale_com_extra'],'integer'],
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
            'name' => Yii::t('app', 'ชื่อ'),
            'description' => Yii::t('app', 'รายละเอียด'),
            'car_type_id' => Yii::t('app', 'ประเภทรถ'),
            'plate_number' => Yii::t('app', 'ทะเบียน'),
            'photo' => Yii::t('app', 'รูป'),
            'meter' => Yii::t('app', 'เลขไมล์'),
            'total_meter' => Yii::t('app', 'เลขไมล์สะสม'),
            'status' => Yii::t('app', 'สถานะ'),
            'sale_group_id' => Yii::t('app', 'กลุ่มสายส่ง'),
            'sale_com_id' => Yii::t('app', 'กลุ่มคอมมิชชั่น'),
            'sale_com_extra' => Yii::t('app', 'กลุ่มค่าพิเศษ'),
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
