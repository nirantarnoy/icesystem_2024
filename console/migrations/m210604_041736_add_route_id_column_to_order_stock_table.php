<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order_stock}}`.
 */
class m210604_041736_add_route_id_column_to_order_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order_stock}}', 'route_id', $this->integer());
        $this->addColumn('{{%order_stock}}', 'trans_date', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order_stock}}', 'route_id');
        $this->dropColumn('{{%order_stock}}', 'trans_date');
    }
}
