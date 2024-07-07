<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%journal_stock}}`.
 */
class m210508_050224_add_company_id_column_to_journal_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%journal_stock}}', 'company_id', $this->integer());
        $this->addColumn('{{%journal_stock}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%journal_stock}}', 'company_id');
        $this->dropColumn('{{%journal_stock}}', 'branch_id');
    }
}
