<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stock_daily_sum}}`.
 */
class m211006_094720_add_login_date_column_to_stock_daily_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_daily_sum}}', 'login_date', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_daily_sum}}', 'login_date');
    }
}
