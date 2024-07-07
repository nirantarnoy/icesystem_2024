<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%orders}}`.
 */
class m210123_124805_add_sale_channel_id_column_to_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%orders}}', 'sale_channel_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%orders}}', 'sale_channel_id');
    }
}
