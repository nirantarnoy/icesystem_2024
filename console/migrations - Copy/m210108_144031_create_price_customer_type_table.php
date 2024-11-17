<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%price_customer_type}}`.
 */
class m210108_144031_create_price_customer_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%price_customer_type}}', [
            'id' => $this->primaryKey(),
            'price_group_id' => $this->integer(),
            'customer_type_id' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%price_customer_type}}');
    }
}
