<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sale_daily_sum}}`.
 */
class m210427_133309_create_sale_daily_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sale_daily_sum}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'total_cash_qty' => $this->integer(),
            'total_credit_qty' => $this->integer(),
            'total_cash_price' => $this->float(),
            'total_credit_price' => $this->float(),
            'balance_in' => $this->integer(),
            'total_prod_qty' => $this->integer(),
            'emp_id' => $this->integer(),
            'trans_shift' => $this->integer(),
            'trans_date' => $this->datetime(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sale_daily_sum}}');
    }
}
