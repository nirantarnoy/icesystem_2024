<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_receive}}`.
 */
class m210307_091355_create_payment_receive_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment_receive}}', [
            'id' => $this->primaryKey(),
            'trans_date' => $this->datetime(),
            'journal_no' => $this->string(),
            'customer_id' => $this->integer(),
            'created_at' => $this->integer(),
            'crated_by' => $this->integer(),
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
        $this->dropTable('{{%payment_receive}}');
    }
}
