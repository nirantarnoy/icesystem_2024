<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_invoice_line}}`.
 */
class m211029_020650_create_customer_invoice_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_invoice_line}}', [
            'id' => $this->primaryKey(),
            'customer_invoice_id' => $this->integer(),
            'order_id' => $this->integer(),
            'amount' => $this->float(),
            'status' => $this->integer(),
            'remain_amount'=> $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_invoice_line}}');
    }
}
