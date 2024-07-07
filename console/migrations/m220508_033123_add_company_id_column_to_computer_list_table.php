<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%computer_list}}`.
 */
class m220508_033123_add_company_id_column_to_computer_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%computer_list}}', 'company_id', $this->integer());
        $this->addColumn('{{%computer_list}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%computer_list}}', 'company_id');
        $this->dropColumn('{{%computer_list}}', 'branch_id');
    }
}
