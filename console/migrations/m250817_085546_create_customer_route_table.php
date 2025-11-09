<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_route}}`.
 */
class m250817_085546_create_customer_route_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_route}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(),
            'route_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_route}}');
    }
}
