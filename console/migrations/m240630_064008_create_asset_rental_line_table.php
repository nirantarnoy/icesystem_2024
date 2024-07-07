<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%asset_rental_line}}`.
 */
class m240630_064008_create_asset_rental_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%asset_rental_line}}', [
            'id' => $this->primaryKey(),
            'asset_rental_id' => $this->integer(),
            'asset_id' => $this->integer(),
            'price' => $this->float(),
            'customer_name' => $this->string(),
            'phone' => $this->string(),
            'receive_name' => $this->string(),
            'emp_id' => $this->integer(),
            'emp_name' => $this->string(),
            'remark' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%asset_rental_line}}');
    }
}
