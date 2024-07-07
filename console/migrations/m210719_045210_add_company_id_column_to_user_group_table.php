<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_group}}`.
 */
class m210719_045210_add_company_id_column_to_user_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_group}}', 'company_id', $this->integer());
        $this->addColumn('{{%user_group}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_group}}', 'company_id');
        $this->dropColumn('{{%user_group}}', 'branch_id');
    }
}
