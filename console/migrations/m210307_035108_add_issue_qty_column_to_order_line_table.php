<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order_line}}`.
 */
class m210307_035108_add_issue_qty_column_to_order_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order_line}}', 'issue_qty', $this->integer());
        $this->addColumn('{{%order_line}}', 'available_qty', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order_line}}', 'issue_qty');
        $this->dropColumn('{{%order_line}}', 'available_qty');
    }
}
