<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%login_log}}`.
 */
class m210427_135549_create_login_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%login_log}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'login_date' => $this->datetime(),
            'logout_date' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%login_log}}');
    }
}
