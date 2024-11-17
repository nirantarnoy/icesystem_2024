<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%journal_transfer}}`.
 */
class m210220_024137_create_journal_transfer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%journal_transfer}}', [
            'id' => $this->primaryKey(),
            'journ_no' => $this->string(),
            'trans_date' => $this->datetime(),
            'order_ref_id' => $this->integer(),
            'order_target_id' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'update_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%journal_transfer}}');
    }
}
