<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%journal_issue_line}}`.
 */
class m210921_084052_add_origin_qty_column_to_journal_issue_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%journal_issue_line}}', 'origin_qty', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%journal_issue_line}}', 'origin_qty');
    }
}
