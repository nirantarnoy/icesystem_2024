<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transfer_line}}`.
 */
class m210220_024422_create_transfer_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transfer_line}}', [
            'id' => $this->primaryKey(),
            'transfer_id' => $this->integer(),
            'product_id' => $this->integer(),
            'sale_price' => $this->float(),
            'qty' => $this->integer(),
            'created_at' => $this->integer(),
            'status' => $this->integer(),
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
        $this->dropTable('{{%transfer_line}}');
    }
}
