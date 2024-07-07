<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "issue_reprocess".
 *
 * @property int $id
 * @property string|null $journal_no
 * @property string|null $trans_date
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class IssueReprocess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issue_reprocess';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date'], 'safe'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by','company_id','branch_id'], 'integer'],
            [['journal_no','reason'], 'string', 'max' => 255],
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
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
