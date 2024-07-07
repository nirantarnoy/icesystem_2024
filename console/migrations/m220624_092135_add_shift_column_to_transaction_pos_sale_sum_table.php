<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%transaction_pos_sale_sum}}`.
 */
class m220624_092135_add_shift_column_to_transaction_pos_sale_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transaction_pos_sale_sum}}', 'shift', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%transaction_pos_sale_sum}}', 'shift');
    }
}
