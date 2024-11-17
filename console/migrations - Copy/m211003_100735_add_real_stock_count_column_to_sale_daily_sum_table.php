<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sale_daily_sum}}`.
 */
class m211003_100735_add_real_stock_count_column_to_sale_daily_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_daily_sum}}', 'real_stock_count', $this->float());
        $this->addColumn('{{%sale_daily_sum}}', 'line_diff', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_daily_sum}}', 'real_stock_count');
        $this->dropColumn('{{%sale_daily_sum}}', 'line_diff');
    }
}
