<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reprint_log}}`.
 */
class m260524_033300_create_reprint_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reprint_log}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'printed_by' => $this->integer()->notNull(),
            'printed_at' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%reprint_log}}');
    }
}
