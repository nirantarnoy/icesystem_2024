<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_journal".
 *
 * @property int $id
 * @property string|null $journal_no
 * @property string|null $trans_date
 * @property int|null $created_at
 * @property int|null $created_by
 */
class StockJournal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock_journal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date'], 'safe'],
            [['created_at', 'created_by'], 'integer'],
            [['journal_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'journal_no' => 'Journal No',
            'trans_date' => 'Trans Date',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}
