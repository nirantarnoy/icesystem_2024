<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order_line}}`.
 */
class m210129_170113_add_price_group_id_column_to_order_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order_line}}', 'price_group_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order_line}}', 'price_group_id');
    }
}
