<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_request_attatch_doc".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $status
 */
class CustomerRequestAttatchDoc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_request_attatch_doc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
        ];
    }
}
