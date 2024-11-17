<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%login_log}}`.
 */
class m210427_140959_add_status_column_to_login_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%login_log}}', 'status', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%login_log}}', 'status');
    }
}
