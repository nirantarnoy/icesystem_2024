<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%login_log_cal}}`.
 */
class m211118_093415_add_logout_date_column_to_login_log_cal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%login_log_cal}}', 'logout_date', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%login_log_cal}}', 'logout_date');
    }
}
