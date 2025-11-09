<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cus_req_doc_standard_assign_photo}}`.
 */
class m250928_040239_create_cus_req_doc_standard_assign_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cus_req_doc_standard_assign_photo}}', [
            'id' => $this->primaryKey(),
            'cus_req_doc_standard_assign_id' => $this->integer(),
            'photo' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cus_req_doc_standard_assign_photo}}');
    }
}
