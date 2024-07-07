<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%login_log_cal}}`.
 */
class m211118_011912_create_login_log_cal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%login_log_cal}}', [
            'id' => $this->primaryKey(),
            'login_date' => $this->datetime(),
            'user_id' => $this->integer(),
            'ip' => $this->string(),
            'status' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%login_log_cal}}');
    }
}
