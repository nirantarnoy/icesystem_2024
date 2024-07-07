<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m210304_033055_add_group_id_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'group_id', $this->integer());
        $this->addColumn('{{%user}}', 'employee_ref_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'group_id');
        $this->dropColumn('{{%user}}', 'employee_ref_id');
    }
}
