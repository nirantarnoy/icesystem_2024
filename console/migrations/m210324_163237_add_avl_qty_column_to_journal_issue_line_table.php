<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%journal_issue_line}}`.
 */
class m210324_163237_add_avl_qty_column_to_journal_issue_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%journal_issue_line}}', 'avl_qty', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%journal_issue_line}}', 'avl_qty');
    }
}
