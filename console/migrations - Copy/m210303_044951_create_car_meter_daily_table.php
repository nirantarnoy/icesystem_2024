<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%car_meter_daily}}`.
 */
class m210303_044951_create_car_meter_daily_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car_meter_daily}}', [
            'id' => $this->primaryKey(),
            'car_id' => $this->integer(),
            'before_meter' => $this->float(),
            'affer_meter' => $this->float(),
            'trans_date' => $this->datetime(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%car_meter_daily}}');
    }
}
