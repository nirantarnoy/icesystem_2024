<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sale_pos_close_cash_qty}}`.
 */
class m230107_094324_create_sale_pos_close_cash_qty_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sale_pos_close_cash_qty}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'start_date' => $this->datetime(),
            'end_date' => $this->datetime(),
            'qty' => $this->float(),
            'user_id' => $this->integer(),
            'trans_date' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sale_pos_close_cash_qty}}');
    }
}
