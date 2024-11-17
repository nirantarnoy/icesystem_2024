<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%machine_layout}}`.
 */
class m220530_150202_create_machine_layout_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%machine_layout}}', [
            'id' => $this->primaryKey(),
            'machine_id' => $this->integer(),
            'rows_name'=> $this->string(),
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
        $this->dropTable('{{%machine_layout}}');
    }
}
