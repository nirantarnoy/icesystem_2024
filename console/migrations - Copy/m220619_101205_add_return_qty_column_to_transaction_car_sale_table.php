<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%transaction_car_sale}}`.
 */
class m220619_101205_add_return_qty_column_to_transaction_car_sale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transaction_car_sale}}', 'return_qty', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%transaction_car_sale}}', 'return_qty');
    }
}
