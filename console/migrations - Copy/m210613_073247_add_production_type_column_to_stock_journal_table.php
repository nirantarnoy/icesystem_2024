<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stock_journal}}`.
 */
class m210613_073247_add_production_type_column_to_stock_journal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%stock_journal}}', 'production_type', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%stock_journal}}', 'production_type');
    }
}
