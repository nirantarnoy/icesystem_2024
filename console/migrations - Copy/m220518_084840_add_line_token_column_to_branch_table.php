<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%branch}}`.
 */
class m220518_084840_add_line_token_column_to_branch_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%branch}}', 'line_token', $this->string());
        $this->addColumn('{{%branch}}', 'line_token_2', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%branch}}', 'line_token');
        $this->dropColumn('{{%branch}}', 'line_token_2');
    }
}
