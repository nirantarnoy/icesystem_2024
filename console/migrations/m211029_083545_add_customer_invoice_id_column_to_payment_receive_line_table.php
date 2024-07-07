<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%payment_receive_line}}`.
 */
class m211029_083545_add_customer_invoice_id_column_to_payment_receive_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payment_receive_line}}', 'customer_invoice_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%payment_receive_line}}', 'customer_invoice_id');
    }
}
