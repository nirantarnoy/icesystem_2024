<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%journal_transfer}}`.
 */
class m210405_094113_add_company_id_column_to_journal_transfer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%journal_transfer}}', 'company_id', $this->integer());
        $this->addColumn('{{%journal_transfer}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%journal_transfer}}', 'company_id');
        $this->dropColumn('{{%journal_transfer}}', 'branch_id');
    }
}
