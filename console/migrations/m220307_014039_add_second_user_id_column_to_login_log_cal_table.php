<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%login_log_cal}}`.
 */
class m220307_014039_add_second_user_id_column_to_login_log_cal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%login_log_cal}}', 'second_user_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%login_log_cal}}', 'second_user_id');
    }
}
