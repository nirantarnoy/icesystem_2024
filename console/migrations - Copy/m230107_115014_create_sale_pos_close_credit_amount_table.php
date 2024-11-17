<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sale_pos_close_credit_amount}}`.
 */
class m230107_115014_create_sale_pos_close_credit_amount_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sale_pos_close_credit_amount}}', [
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
        $this->dropTable('{{%sale_pos_close_credit_amount}}');
    }
}
