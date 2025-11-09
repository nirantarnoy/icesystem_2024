<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_request_attatch_doc}}`.
 */
class m250615_080230_create_customer_request_attatch_doc_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_request_attatch_doc}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_request_attatch_doc}}');
    }
}
