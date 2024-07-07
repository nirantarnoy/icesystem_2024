<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%journal_issue}}`.
 */
class m210829_051502_add_plan_id_column_to_journal_issue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%journal_issue}}', 'plan_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%journal_issue}}', 'plan_id');
    }
}
