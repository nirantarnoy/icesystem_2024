<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sale_daily_sum}}`.
 */
class m210502_110611_add_balance_out_column_to_sale_daily_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_daily_sum}}', 'balance_out', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_daily_sum}}', 'balance_out');
    }
}
