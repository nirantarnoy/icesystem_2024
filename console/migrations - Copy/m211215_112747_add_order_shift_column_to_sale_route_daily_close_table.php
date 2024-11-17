<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sale_route_daily_close}}`.
 */
class m211215_112747_add_order_shift_column_to_sale_route_daily_close_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_route_daily_close}}', 'order_shift', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_route_daily_close}}', 'order_shift');
    }
}
