<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%car_daily}}`.
 */
class m210122_022612_create_car_daily_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car_daily}}', [
            'id' => $this->primaryKey(),
            'car_id' => $this->integer(),
            'employee_id' => $this->integer(),
            'is_driver' => $this->integer(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%car_daily}}');
    }
}
