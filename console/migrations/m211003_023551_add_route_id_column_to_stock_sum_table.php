<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stock_sum}}`.
 */
class m211003_023551_add_route_id_column_to_stock_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%stock_sum}}', 'route_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%stock_sum}}', 'route_id');
    }
}
