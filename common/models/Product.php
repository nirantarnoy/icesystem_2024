<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $description
 * @property int|null $product_type_id
 * @property int|null $product_group_id
 * @property string|null $photo
 * @property float|null $std_cost
 * @property float|null $sale_price
 * @property int|null $unit_id
 * @property float|null $nw
 * @property float|null $gw
 * @property float|null $min_stock
 * @property float|null $max_stock
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
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          //  [['code'],'unique'],
            [['product_type_id', 'product_group_id', 'unit_id', 'status', 'company_id', 'branch_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['std_cost', 'sale_price', 'nw', 'gw', 'min_stock', 'max_stock'], 'number'],
            [['code', 'name', 'description', 'photo'], 'string', 'max' => 255],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['barcode'],'string'],
            [['stock_type','sale_status','is_pos_item','item_pos_seq','stock_on_car','master_product'],'integer']
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
            'name' => Yii::t('app', 'ชื่อสินค้า'),
            'description' => Yii::t('app', 'รายละเอียด'),
            'product_type_id' => Yii::t('app', 'ประเภทสินค้า'),
            'product_group_id' => Yii::t('app', 'กลุ่มสินค้า'),
            'photo' => Yii::t('app', 'รูปภาพ'),
            'std_cost' => Yii::t('app', 'ต้นทุน'),
            'sale_price' => Yii::t('app', 'ราคาขาย'),
            'unit_id' => Yii::t('app', 'หน่วยนับ'),
            'nw' => Yii::t('app', 'น้ำหนัก'),
            'gw' => Yii::t('app', 'Gw'),
            'min_stock' => Yii::t('app', 'Min Stock'),
            'max_stock' => Yii::t('app', 'Max Stock'),
            'status' => Yii::t('app', 'สถานะ'),
            'company_id' => Yii::t('app', 'บริษัท'),
            'branch_id' => Yii::t('app', 'สาขา'),
            'barcode' => Yii::t('app', 'บาร์โค้ด'),
            'is_pos_item' => 'ใช้กับลูกค้าเงินสด POS',
            'stock_on_car' => 'สต๊อกบนรถ',
            'master_product' => 'สินค้า master',
            'item_pos_seq' => 'ลำดับแสดงรายการ',
            'sale_status' => Yii::t('app', 'สถานะขาย'),
            'stock_type' => Yii::t('app', 'ตัดสต๊อก'),
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
