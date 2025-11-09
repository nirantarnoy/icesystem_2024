<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_request_attatch_doc_select}}`.
 */
class m250615_083805_create_customer_request_attatch_doc_select_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_request_attatch_doc_select}}', [
            'id' => $this->primaryKey(),
            'customer_request_id' => $this->integer(),
            'customer_attatch_doc_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_request_attatch_doc_select}}');
    }
}
