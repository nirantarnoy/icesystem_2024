<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%orders}}`.
 */
class m210623_143111_add_emp_1_column_to_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%orders}}', 'emp_1', $this->integer());
        $this->addColumn('{{%orders}}', 'emp_2', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%orders}}', 'emp_1');
        $this->dropColumn('{{%orders}}', 'emp_2');
    }
}
