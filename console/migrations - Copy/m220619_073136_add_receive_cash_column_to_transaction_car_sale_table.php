<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%transaction_car_sale}}`.
 */
class m220619_073136_add_receive_cash_column_to_transaction_car_sale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transaction_car_sale}}', 'receive_cash', $this->float());
        $this->addColumn('{{%transaction_car_sale}}', 'receive_transter', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%transaction_car_sale}}', 'receive_cash');
        $this->dropColumn('{{%transaction_car_sale}}', 'receive_transter');
    }
}
