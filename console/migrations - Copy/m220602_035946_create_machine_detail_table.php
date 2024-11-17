<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%machine_detail}}`.
 */
class m220602_035946_create_machine_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%machine_detail}}', [
            'id' => $this->primaryKey(),
            'machine_id' => $this->integer(),
            'loc_name' => $this->string(),
            'loc_qty' => $this->integer(),
            'status' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%machine_detail}}');
    }
}
