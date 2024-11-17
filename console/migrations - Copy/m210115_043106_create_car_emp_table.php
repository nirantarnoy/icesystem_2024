<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%car_emp}}`.
 */
class m210115_043106_create_car_emp_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car_emp}}', [
            'id' => $this->primaryKey(),
            'car_id' => $this->integer(),
            'emp_id' => $this->integer(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%car_emp}}');
    }
}
