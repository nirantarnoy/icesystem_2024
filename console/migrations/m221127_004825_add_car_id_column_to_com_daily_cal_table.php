<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%com_daily_cal}}`.
 */
class m221127_004825_add_car_id_column_to_com_daily_cal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%com_daily_cal}}', 'car_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%com_daily_cal}}', 'car_id');
    }
}
