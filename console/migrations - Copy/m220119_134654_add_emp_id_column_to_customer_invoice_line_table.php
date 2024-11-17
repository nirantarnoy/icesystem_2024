<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer_invoice_line}}`.
 */
class m220119_134654_add_emp_id_column_to_customer_invoice_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer_invoice_line}}', 'emp_id', $this->integer());
        $this->addColumn('{{%customer_invoice_line}}', 'created_at', $this->integer());
        $this->addColumn('{{%customer_invoice_line}}', 'updated_at', $this->integer());
        $this->addColumn('{{%customer_invoice_line}}', 'created_by', $this->integer());
        $this->addColumn('{{%customer_invoice_line}}', 'updated_by', $this->integer());
        $this->addColumn('{{%customer_invoice_line}}', 'recieve_amount', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer_invoice_line}}', 'emp_id');
        $this->dropColumn('{{%customer_invoice_line}}', 'created_at');
        $this->dropColumn('{{%customer_invoice_line}}', 'updated_at');
        $this->dropColumn('{{%customer_invoice_line}}', 'created_by');
        $this->dropColumn('{{%customer_invoice_line}}', 'updated_by');
        $this->dropColumn('{{%customer_invoice_line}}', 'recieve_amount');
    }
}
