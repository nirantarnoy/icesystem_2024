<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer_invoice}}`.
 */
class m211029_030225_add_company_column_to_customer_invoice_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer_invoice}}', 'company_id', $this->integer());
        $this->addColumn('{{%customer_invoice}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer_invoice}}', 'company_id');
        $this->dropColumn('{{%customer_invoice}}', 'branch_id');
    }
}
