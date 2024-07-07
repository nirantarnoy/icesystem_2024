<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%machine}}`.
 */
class m220525_154218_create_machine_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%machine}}', [
            'id' => $this->primaryKey(),
            'machine_no' => $this->string(),
            'name' => $this->string(),
            'description' => $this->string(),
            'warehouse_id' => $this->integer(),
            'rows' => $this->integer(),
            'sub_rows' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
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
        $this->dropTable('{{%machine}}');
    }
}
