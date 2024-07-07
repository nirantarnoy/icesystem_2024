<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sale_group}}`.
 */
class m210507_045822_add_company_id_column_to_sale_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_group}}', 'company_id', $this->integer());
        $this->addColumn('{{%sale_group}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_group}}', 'company_id');
        $this->dropColumn('{{%sale_group}}', 'branch_id');
    }
}
