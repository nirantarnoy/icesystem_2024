<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cus_req_doc_standard}}`.
 */
class m250920_044703_create_cus_req_doc_standard_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cus_req_doc_standard}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cus_req_doc_standard}}');
    }
}
