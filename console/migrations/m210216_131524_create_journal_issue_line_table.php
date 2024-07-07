<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%journal_issue_line}}`.
 */
class m210216_131524_create_journal_issue_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%journal_issue_line}}', [
            'id' => $this->primaryKey(),
            'issue_id' => $this->integer(),
            'product_id' => $this->integer(),
            'warehouse_id' => $this->integer(),
            'location_id' => $this->integer(),
            'qty' => $this->float(),
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
        $this->dropTable('{{%journal_issue_line}}');
    }
}
