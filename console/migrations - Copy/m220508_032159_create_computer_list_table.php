<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%computer_list}}`.
 */
class m220508_032159_create_computer_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%computer_list}}', [
            'id' => $this->primaryKey(),
            'computer_name' => $this->string(),
            'mac_address' => $this->string(),
            'ip_address' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%computer_list}}');
    }
}
