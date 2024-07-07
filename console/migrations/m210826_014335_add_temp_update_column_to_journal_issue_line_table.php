<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%journal_issue_line}}`.
 */
class m210826_014335_add_temp_update_column_to_journal_issue_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%journal_issue_line}}', 'temp_update', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%journal_issue_line}}', 'temp_update');
    }
}
