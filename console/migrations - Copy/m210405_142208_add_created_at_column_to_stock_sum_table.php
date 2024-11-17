<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stock_sum}}`.
 */
class m210405_142208_add_created_at_column_to_stock_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%stock_sum}}', 'created_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%stock_sum}}', 'created_at');
    }
}
