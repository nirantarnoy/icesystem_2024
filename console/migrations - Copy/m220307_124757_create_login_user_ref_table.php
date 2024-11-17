<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%login_user_ref}}`.
 */
class m220307_124757_create_login_user_ref_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%login_user_ref}}', [
            'id' => $this->primaryKey(),
            'login_log_cal_id' => $this->integer(),
            'user_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%login_user_ref}}');
    }
}
