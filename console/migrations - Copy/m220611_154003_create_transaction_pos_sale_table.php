<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transaction_pos_sale}}`.
 */
class m220611_154003_create_transaction_pos_sale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transaction_pos_sale}}', [
            'id' => $this->primaryKey(),
            'trans_date' => $this->datetime(),
            'customer_id' => $this->integer(),
            'customer_type_id' => $this->integer(),
            'product_id' => $this->integer(),
            'credit_qty' => $this->float(),
            'cash_qty' => $this->float(),
            'credit_amount' => $this->float(),
            'cash_amount' => $this->float(),
            'cash_receive' => $this->float(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'created_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transaction_pos_sale}}');
    }
}
