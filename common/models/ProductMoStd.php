<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_mo_std".
 *
 * @property int $id
 * @property float|null $level1_qty
 * @property float|null $level2_qty
 * @property float|null $level3_qty
 * @property float|null $level4_qty
 */
class ProductMoStd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_mo_std';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level1_qty', 'level2_qty', 'level3_qty', 'level4_qty'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level1_qty' => 'Level1 Qty',
            'level2_qty' => 'Level2 Qty',
            'level3_qty' => 'Level3 Qty',
            'level4_qty' => 'Level4 Qty',
        ];
    }
}
