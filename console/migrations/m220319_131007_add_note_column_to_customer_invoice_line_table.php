<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer_invoice_line}}`.
 */
class m220319_131007_add_note_column_to_customer_invoice_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer_invoice_line}}', 'note', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer_invoice_line}}', 'note');
    }
}
