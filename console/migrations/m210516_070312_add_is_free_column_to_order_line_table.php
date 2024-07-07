<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order_line}}`.
 */
class m210516_070312_add_is_free_column_to_order_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order_line}}', 'is_free', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order_line}}', 'is_free');
    }
}
