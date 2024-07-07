<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%issue_stock_temp}}`.
 */
class m210808_103902_add_company_id_column_to_issue_stock_temp_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%issue_stock_temp}}', 'company_id', $this->integer());
        $this->addColumn('{{%issue_stock_temp}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%issue_stock_temp}}', 'company_id');
        $this->dropColumn('{{%issue_stock_temp}}', 'branch_id');
    }
}
