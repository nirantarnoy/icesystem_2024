<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stock_journal}}`.
 */
class m210604_074323_add_company_id_column_to_stock_journal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%stock_journal}}', 'company_id', $this->integer());
        $this->addColumn('{{%stock_journal}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%stock_journal}}', 'company_id');
        $this->dropColumn('{{%stock_journal}}', 'branch_id');
    }
}
