<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sale_balance_out}}`.
 */
class m210503_141047_create_sale_balance_out_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sale_balance_out}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'trans_date' => $this->datetime(),
            'product_id' => $this->integer(),
            'balance_out' => $this->integer(),
            'created_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sale_balance_out}}');
    }
}
