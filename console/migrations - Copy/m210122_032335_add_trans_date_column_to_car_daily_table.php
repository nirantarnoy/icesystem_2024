<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%car_daily}}`.
 */
class m210122_032335_add_trans_date_column_to_car_daily_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%car_daily}}', 'trans_date', $this->datetime());
        $this->addColumn('{{%car_daily}}', 'created_at', $this->integer());
        $this->addColumn('{{%car_daily}}', 'updated_at', $this->integer());
        $this->addColumn('{{%car_daily}}', 'created_by', $this->integer());
        $this->addColumn('{{%car_daily}}', 'updated_by', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%car_daily}}', 'trans_date');
        $this->dropColumn('{{%car_daily}}', 'created_at');
        $this->dropColumn('{{%car_daily}}', 'updated_at');
        $this->dropColumn('{{%car_daily}}', 'created_by');
        $this->dropColumn('{{%car_daily}}', 'updated_by');
    }
}
