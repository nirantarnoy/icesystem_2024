<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_products".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $description
 * @property int|null $product_type_id
 * @property int|null $product_group_id
 * @property string|null $type_code
 * @property string|null $type_name
 * @property string|null $group_code
 * @property string|null $group_name
 * @property string|null $status
 */
class QueryProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_type_id', 'product_group_id'], 'integer'],
            [['code', 'name', 'description', 'type_code', 'type_name', 'group_code', 'group_name'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 9],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'product_type_id' => Yii::t('app', 'Product Type ID'),
            'product_group_id' => Yii::t('app', 'Product Group ID'),
            'type_code' => Yii::t('app', 'Type Code'),
            'type_name' => Yii::t('app', 'Type Name'),
            'group_code' => Yii::t('app', 'Group Code'),
            'group_name' => Yii::t('app', 'Group Name'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
