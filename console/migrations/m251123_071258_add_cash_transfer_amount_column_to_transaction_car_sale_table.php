<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%transaction_car_sale}}`.
 */
class m251123_071258_add_cash_transfer_amount_column_to_transaction_car_sale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transaction_car_sale}}', 'cash_transfer_amount', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%transaction_car_sale}}', 'cash_transfer_amount');
    }
}
