<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "journal_stock".
 *
 * @property int $id
 * @property string|null $journal_no
 * @property string|null $trans_date
 * @property string|null $description
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 */
class JournalStock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'journal_stock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date'], 'safe'],
            [['status', 'created_at', 'created_by','company_id','branch_id'], 'integer'],
            [['journal_no', 'description'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}
