<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sale_com_summary}}`.
 */
class m210507_133632_add_company_id_column_to_sale_com_summary_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_com_summary}}', 'company_id', $this->integer());
        $this->addColumn('{{%sale_com_summary}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_com_summary}}', 'company_id');
        $this->dropColumn('{{%sale_com_summary}}', 'branch_id');
    }
}
