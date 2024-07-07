<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_stock}}`.
 */
class m210410_004922_create_order_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_stock}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'issue_id' => $this->integer(),
            'product_id' => $this->integer(),
            'qty' => $this->integer(),
            'used_qty' => $this->integer(),
            'avl_qty' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_stock}}');
    }
}
