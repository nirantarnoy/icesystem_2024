<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sequence".
 *
 * @property int $id
 * @property int|null $plant_id
 * @property int|null $module_id
 * @property string|null $prefix
 * @property string|null $symbol
 * @property int|null $use_year
 * @property int|null $use_month
 * @property int|null $use_day
 * @property int|null $minimum
 * @property int|null $maximum
 * @property int|null $currentnum
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Sequence extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sequence';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['plant_id', 'module_id', 'use_year', 'use_month', 'use_day', 'minimum', 'maximum', 'currentnum', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by','company_id','branch_id'], 'integer'],
            [['prefix', 'symbol'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'plant_id' => Yii::t('app', 'Plant ID'),
            'module_id' => Yii::t('app', 'Module ID'),
            'prefix' => Yii::t('app', 'Prefix'),
            'symbol' => Yii::t('app', 'Symbol'),
            'use_year' => Yii::t('app', 'Use Year'),
            'use_month' => Yii::t('app', 'Use Month'),
            'use_day' => Yii::t('app', 'Use Day'),
            'minimum' => Yii::t('app', 'Minimum'),
            'maximum' => Yii::t('app', 'Maximum'),
            'currentnum' => Yii::t('app', 'Currentnum'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
