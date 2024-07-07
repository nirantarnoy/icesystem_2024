<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%car_daily}}`.
 */
class m210405_094020_add_company_id_column_to_car_daily_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%car_daily}}', 'company_id', $this->integer());
        $this->addColumn('{{%car_daily}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%car_daily}}', 'company_id');
        $this->dropColumn('{{%car_daily}}', 'branch_id');
    }
}
