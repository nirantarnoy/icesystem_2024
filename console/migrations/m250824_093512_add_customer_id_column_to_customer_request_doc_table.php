<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer_request_doc}}`.
 */
class m250824_093512_add_customer_id_column_to_customer_request_doc_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer_request_doc}}', 'customer_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer_request_doc}}', 'customer_id');
    }
}
