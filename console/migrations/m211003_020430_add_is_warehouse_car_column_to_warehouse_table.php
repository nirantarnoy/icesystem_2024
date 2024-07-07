<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%warehouse}}`.
 */
class m211003_020430_add_is_warehouse_car_column_to_warehouse_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%warehouse}}', 'is_warehouse_car', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%warehouse}}', 'is_warehouse_car');
    }
}
