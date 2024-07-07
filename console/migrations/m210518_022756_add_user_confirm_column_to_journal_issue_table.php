<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%journal_issue}}`.
 */
class m210518_022756_add_user_confirm_column_to_journal_issue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%journal_issue}}', 'user_confirm', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%journal_issue}}', 'user_confirm');
    }
}
