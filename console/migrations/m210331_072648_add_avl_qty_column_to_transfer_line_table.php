<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%transfer_line}}`.
 */
class m210331_072648_add_avl_qty_column_to_transfer_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transfer_line}}', 'avl_qty', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%transfer_line}}', 'avl_qty');
    }
}
