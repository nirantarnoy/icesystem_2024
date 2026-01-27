<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer}}`.
 */
class m260124_071223_add_car_id_column_to_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer}}', 'car_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer}}', 'car_id');
    }
}
