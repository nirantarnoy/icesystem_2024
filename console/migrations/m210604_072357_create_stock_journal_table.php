<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_journal}}`.
 */
class m210604_072357_create_stock_journal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stock_journal}}', [
            'id' => $this->primaryKey(),
            'journal_no' => $this->string(),
            'trans_date' => $this->datetime(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stock_journal}}');
    }
}
