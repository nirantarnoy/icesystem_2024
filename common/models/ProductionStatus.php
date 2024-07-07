<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "production_status".
 *
 * @property int $id
 * @property int|null $loc_id
 * @property string|null $loc_name
 * @property string|null $color_status
 * @property string|null $start_date
 * @property string|null $end_date
 * @property float|null $total_hour
 * @property string|null $updated_date
 * @property int|null $updated_by
 */
class ProductionStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'production_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loc_id', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'updated_date'], 'safe'],
            [['total_hour'], 'number'],
            [['loc_name', 'color_status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loc_id' => 'Loc ID',
            'loc_name' => 'Loc Name',
            'color_status' => 'Color Status',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'total_hour' => 'Total Hour',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
        ];
    }
}
