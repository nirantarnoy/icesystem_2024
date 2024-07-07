<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%daily_count_stock}}`.
 */
class m211115_145848_add_journal_no_column_to_daily_count_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%daily_count_stock}}', 'journal_no', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%daily_count_stock}}', 'journal_no');
    }
}
