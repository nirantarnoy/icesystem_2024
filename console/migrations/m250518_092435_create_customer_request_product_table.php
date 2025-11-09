<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_request_product}}`.
 */
class m250518_092435_create_customer_request_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_request_product}}', [
            'id' => $this->primaryKey(),
            'customer_req_id' => $this->integer(),
            'product_id' => $this->integer(),
            'product_name' => $this->string(),
            'price' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_request_product}}');
    }
}
