<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer_request_doc}}`.
 */
class m250614_140932_add_doc_name_column_to_customer_request_doc_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer_request_doc}}', 'doc_name', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer_request_doc}}', 'doc_name');
    }
}
