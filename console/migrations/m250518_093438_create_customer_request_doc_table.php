<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_request_doc}}`.
 */
class m250518_093438_create_customer_request_doc_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_request_doc}}', [
            'id' => $this->primaryKey(),
            'customer_req_id' => $this->integer(),
            'doc_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_request_doc}}');
    }
}
