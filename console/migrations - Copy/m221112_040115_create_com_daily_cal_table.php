<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%com_daily_cal}}`.
 */
class m221112_040115_create_com_daily_cal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%com_daily_cal}}', [
            'id' => $this->primaryKey(),
            'trans_date' => $this->datetime(),
            'emp_1' => $this->integer(),
            'emp_2' => $this->integer(),
            'total_qty' => $this->float(),
            'total_amt' => $this->float(),
            'line_com_amt' => $this->float(),
            'line_com_special_amt' => $this->float(),
            'line_total_amt' => $this->float(),
            'created_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%com_daily_cal}}');
    }
}
