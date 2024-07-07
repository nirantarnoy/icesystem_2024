<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_invoice}}`.
 */
class m211029_020543_create_customer_invoice_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_invoice}}', [
            'id' => $this->primaryKey(),
            'journal_no' => $this->string(),
            'trans_date' => $this->datetime(),
            'customer_id' => $this->integer(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_invoice}}');
    }
}
