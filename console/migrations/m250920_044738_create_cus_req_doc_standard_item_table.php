<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cus_req_doc_standard_item}}`.
 */
class m250920_044738_create_cus_req_doc_standard_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cus_req_doc_standard_item}}', [
            'id' => $this->primaryKey(),
            'cus_req_standard_id' => $this->integer(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cus_req_doc_standard_item}}');
    }
}
