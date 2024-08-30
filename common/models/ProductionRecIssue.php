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
class ProductionRecIssue extends \yii\db\ActiveRecord
{
    public $emp_id;

    public static function tableName()
    {
        return 'production_rec_issue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['"stock_trans_id', 'product_id', 'issue_id'], 'integer'],
            [['qty'],'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'stock_trans_id' => Yii::t('app', 'Stock ID'),
            'product_id' => Yii::t('app', 'สินค้า'),
            'issue_id' => Yii::t('app', 'เบิก'),
            'qty' => Yii::t('app', 'จำนวน'),

        ];
    }


}
