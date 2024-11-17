<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%com_daily_cal}}`.
 */
class m221112_043357_add_route_id_column_to_com_daily_cal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%com_daily_cal}}', 'route_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%com_daily_cal}}', 'route_id');
    }
}
