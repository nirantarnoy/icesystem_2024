<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%transaction_pos_sale_sum}}`.
 */
class m220627_073125_add_logout_datetime_column_to_transaction_pos_sale_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transaction_pos_sale_sum}}', 'logout_datetime', $this->datetime());
        $this->addColumn('{{%transaction_pos_sale_sum}}', 'user_second_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%transaction_pos_sale_sum}}', 'logout_datetime');
        $this->dropColumn('{{%transaction_pos_sale_sum}}', 'user_second_id');
    }
}
