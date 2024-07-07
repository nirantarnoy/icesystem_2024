<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%com_daily_cal}}`.
 */
class m221127_005506_add_company_id_column_to_com_daily_cal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%com_daily_cal}}', 'company_id', $this->integer());
        $this->addColumn('{{%com_daily_cal}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%com_daily_cal}}', 'company_id');
        $this->dropColumn('{{%com_daily_cal}}', 'branch_id');
    }
}
