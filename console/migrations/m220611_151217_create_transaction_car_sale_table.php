<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transaction_car_sale}}`.
 */
class m220611_151217_create_transaction_car_sale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transaction_car_sale}}', [
            'id' => $this->primaryKey(),
            'trans_date' => $this->datetime(),
            'route_id' => $this->integer(),
            'product_id' => $this->integer(),
            'credit_qty' => $this->float(),
            'cash_qty' => $this->float(),
            'credit_amount' => $this->float(),
            'cash_amount' => $this->float(),
            'cash_receive' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transaction_car_sale}}');
    }
}
