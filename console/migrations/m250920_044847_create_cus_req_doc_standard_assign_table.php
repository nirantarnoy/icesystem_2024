<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cus_req_doc_standard_assign}}`.
 */
class m250920_044847_create_cus_req_doc_standard_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cus_req_doc_standard_assign}}', [
            'id' => $this->primaryKey(),
            'cus_req_id' => $this->integer(),
            'cus_req_standard_id' => $this->integer(),
            'cus_req_standard_item_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cus_req_doc_standard_assign}}');
    }
}
