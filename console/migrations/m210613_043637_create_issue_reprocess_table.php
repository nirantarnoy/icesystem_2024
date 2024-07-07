<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%issue_reprocess}}`.
 */
class m210613_043637_create_issue_reprocess_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%issue_reprocess}}', [
            'id' => $this->primaryKey(),
            'journal_no' => $this->string(),
            'trans_date' => $this->datetime(),
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
