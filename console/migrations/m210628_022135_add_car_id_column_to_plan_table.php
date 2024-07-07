<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%plan}}`.
 */
class m210628_022135_add_car_id_column_to_plan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%plan}}', 'car_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%plan}}', 'car_id');
    }
}
