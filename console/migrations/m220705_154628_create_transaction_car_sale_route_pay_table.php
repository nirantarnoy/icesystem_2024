<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transaction_car_sale_route_pay}}`.
 */
class m220705_154628_create_transaction_car_sale_route_pay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transaction_car_sale_route_pay}}', [
            'id' => $this->primaryKey(),
            'route_id' => $this->integer(),
            'trans_date' => $this->datetime(),
            'cash_amount' => $this->float(),
            'transfer_amount' => $this->float(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transaction_car_sale_route_pay}}');
    }
}
