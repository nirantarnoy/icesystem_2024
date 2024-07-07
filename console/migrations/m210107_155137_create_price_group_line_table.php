<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%price_group_line}}`.
 */
class m210107_155137_create_price_group_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%price_group_line}}', [
            'id' => $this->primaryKey(),
            'price_group_id' => $this->integer(),
            'product_id' => $this->integer(),
            'sale_price' => $this->float(),
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
        $this->dropTable('{{%price_group_line}}');
    }
}
