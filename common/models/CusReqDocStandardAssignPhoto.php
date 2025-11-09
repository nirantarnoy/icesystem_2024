<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cus_req_doc_standard_assign_photo".
 *
 * @property int $id
 * @property int|null $cus_req_doc_standard_assign_id
 * @property string|null $photo
 */
class CusReqDocStandardAssignPhoto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cus_req_doc_standard_assign_photo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cus_req_doc_standard_assign_id'], 'integer'],
            [['photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cus_req_doc_standard_assign_id' => 'Cus Req Doc Standard Assign ID',
            'photo' => 'Photo',
        ];
    }
}
