<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%delivery_route_device}}`.
 */
class m241116_033100_create_delivery_route_device_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%delivery_route_device}}', [
            'id' => $this->primaryKey(),
            'delivery_route_id' => $this->integer(),
            'device_register_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%delivery_route_device}}');
    }
}
