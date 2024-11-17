<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_transfer_sale}}`.
 */
class m210224_034159_create_order_transfer_sale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_transfer_sale}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'customer_id' => $this->integer(),
            'product_id' => $this->integer(),
            'qty' => $this->integer(),
            'price' => $this->float(),
            'transfer_id' => $this->integer(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_transfer_sale}}');
    }
}
