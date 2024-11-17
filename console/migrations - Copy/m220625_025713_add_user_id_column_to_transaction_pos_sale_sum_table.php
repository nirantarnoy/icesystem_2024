<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%transaction_pos_sale_sum}}`.
 */
class m220625_025713_add_user_id_column_to_transaction_pos_sale_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transaction_pos_sale_sum}}', 'user_id', $this->integer());
        $this->addColumn('{{%transaction_pos_sale_sum}}', 'login_datetime', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%transaction_pos_sale_sum}}', 'user_id');
        $this->dropColumn('{{%transaction_pos_sale_sum}}', 'login_datetime');
    }
}
