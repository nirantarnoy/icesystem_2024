<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sale_com}}`.
 */
class m210507_045707_add_company_id_column_to_sale_com_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_com}}', 'company_id', $this->integer());
        $this->addColumn('{{%sale_com}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_com}}', 'company_id');
        $this->dropColumn('{{%sale_com}}', 'branch_id');
    }
}
