<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "asset_rental_line".
 *
 * @property int $id
 * @property int|null $asset_rental_id
 * @property int|null $asset_id
 * @property float|null $price
 * @property string|null $customer_name
 * @property string|null $phone
 * @property string|null $receive_name
 * @property int|null $emp_id
 * @property string|null $emp_name
 * @property string|null $remark
 */
class AssetRentalLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asset_rental_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['asset_rental_id', 'asset_id', 'emp_id','use_status','return_status'], 'integer'],
            [['price'], 'number'],
            [['customer_name', 'phone', 'receive_name', 'emp_name', 'remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'asset_rental_id' => 'Asset Rental ID',
            'asset_id' => 'Asset ID',
            'price' => 'Price',
            'customer_name' => 'Customer Name',
            'phone' => 'Phone',
            'receive_name' => 'Receive Name',
            'emp_id' => 'Emp ID',
            'emp_name' => 'Emp Name',
            'remark' => 'Remark',
        ];
    }
}
