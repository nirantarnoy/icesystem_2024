<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_trans}}`.
 */
class m210130_080523_create_payment_trans_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment_trans_line}}', [
            'id' => $this->primaryKey(),
            'trans_id' => $this->integer(),
            'customer_id' => $this->integer(),
            'payment_date' => $this->datetime(),
            'payment_method_id' => $this->integer(),
            'payment_term_id' => $this->integer(),
            'payment_amount' => $this->float(),
            'total_amount' => $this->float(),
            'change_amount' => $this->float(),
            'doc' => $this->string(),
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
        $this->dropTable('{{%payment_trans}}');
    }
}
