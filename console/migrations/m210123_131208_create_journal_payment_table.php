<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%journal_payment}}`.
 */
class m210123_131208_create_journal_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%journal_payment}}', [
            'id' => $this->primaryKey(),
            'journal_no' => $this->string(),
            'trans_date' => $this->string(),
            'order_id' => $this->integer(),
            'payment_method_id' => $this->integer(),
            'payment_term_id' => $this->integer(),
            'total_amount'=>$this->float(),
            'pay_amount'=>$this->float(),
            'change_amount'=>$this->float(),
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
        $this->dropTable('{{%journal_payment}}');
    }
}
