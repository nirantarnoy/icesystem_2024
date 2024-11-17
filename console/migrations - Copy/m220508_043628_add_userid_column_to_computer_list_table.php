<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%computer_list}}`.
 */
class m220508_043628_add_userid_column_to_computer_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%computer_list}}', 'userid', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%computer_list}}', 'userid');
    }
}
