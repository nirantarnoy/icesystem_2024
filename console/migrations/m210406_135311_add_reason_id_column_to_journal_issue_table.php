<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%journal_issue}}`.
 */
class m210406_135311_add_reason_id_column_to_journal_issue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%journal_issue}}', 'reason_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%journal_issue}}', 'reason_id');
    }
}
