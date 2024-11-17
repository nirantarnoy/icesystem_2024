<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transaction_pos_sale_sum}}`.
 */
class m220624_091409_create_transaction_pos_sale_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transaction_pos_sale_sum}}', [
            'id' => $this->primaryKey(),
            'trans_date' => $this->datetime(),
            'product_id' => $this->integer(),
            'credit_qty' => $this->float(),
            'cash_qty' => $this->float(),
            'free_qty' => $this->float(),
            'balance_in_qty' => $this->float(),
            'balance_out_qty' => $this->float(),
            'prodrec_qty' => $this->float(),
            'reprocess_qty' => $this->float(),
            'return_qty' => $this->float(),
            'issue_car_qty' => $this->float(),
            'issue_transfer_qty' => $this->float(),
            'issue_refill_qty' => $this->float(),
            'scrap_qty' => $this->float(),
            'counting_qty' => $this->float(),
            'created_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transaction_pos_sale_sum}}');
    }
}
