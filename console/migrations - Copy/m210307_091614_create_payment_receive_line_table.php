<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_receive_line}}`.
 */
class m210307_091614_create_payment_receive_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment_receive_line}}', [
            'id' => $this->primaryKey(),
            'payment_receive_id' => $this->integer(),
            'order_id' => $this->integer(),
            'product_id' => $this->integer(),
            'remain_amount' => $this->float(),
            'payment_amount' => $this->float(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment_receive_line}}');
    }
}
