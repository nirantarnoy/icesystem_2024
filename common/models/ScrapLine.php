<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "scrap_line".
 *
 * @property int $id
 * @property int|null $scrap_id
 * @property int|null $product_id
 * @property float|null $qty
 * @property int|null $prodrec_id
 * @property string|null $note
 * @property int|null $status
 */
class ScrapLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'scrap_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['scrap_id', 'product_id', 'prodrec_id', 'status'], 'integer'],
            [['qty'], 'number'],
            [['note'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scrap_id' => 'Scrap ID',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'prodrec_id' => 'Prodrec ID',
            'note' => 'Note',
            'status' => 'Status',
        ];
    }
}
