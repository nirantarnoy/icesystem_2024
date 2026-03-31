<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%plan_line}}`.
 */
class m260211_083000_add_round_no_column_to_plan_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%plan_line}}', 'round_no', $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%plan_line}}', 'round_no');
    }
}
