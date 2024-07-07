<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%issue_reprocess}}`.
 */
class m210613_043759_create_issue_reprocess_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%issue_reprocess_line}}', [
            'id' => $this->primaryKey(),
            'issue_id' => $this->integer(),
            'product_id' => $this->integer(),
            'qty' => $this->float(),
            'to_warehouse_id' => $this->integer(),
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
        $this->dropTable('{{%issue_reprocess}}');
    }
}
