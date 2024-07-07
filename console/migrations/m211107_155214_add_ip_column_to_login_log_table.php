<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%login_log}}`.
 */
class m211107_155214_add_ip_column_to_login_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%login_log}}', 'ip', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%login_log}}', 'ip');
    }
}
