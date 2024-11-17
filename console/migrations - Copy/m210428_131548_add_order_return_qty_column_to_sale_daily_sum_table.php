<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sale_daily_sum}}`.
 */
class m210428_131548_add_order_return_qty_column_to_sale_daily_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_daily_sum}}', 'order_return_qty', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_daily_sum}}', 'order_return_qty');
    }
}
