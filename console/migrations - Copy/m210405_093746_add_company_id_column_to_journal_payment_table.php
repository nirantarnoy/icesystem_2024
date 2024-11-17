<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%journal_payment}}`.
 */
class m210405_093746_add_company_id_column_to_journal_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%journal_payment}}', 'company_id', $this->integer());
        $this->addColumn('{{%journal_payment}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%journal_payment}}', 'company_id');
        $this->dropColumn('{{%journal_payment}}', 'branch_id');
    }
}
