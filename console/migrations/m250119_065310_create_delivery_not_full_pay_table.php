<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%delivery_not_full_pay}}`.
 */
class m250119_065310_create_delivery_not_full_pay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%delivery_not_full_pay}}', [
            'id' => $this->primaryKey(),
            'trans_date' => $this->datetime(),
            'route_id' => $this->integer(),
            'cash_transfer_amount' => $this->float(),
            'not_full_amount' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%delivery_not_full_pay}}');
    }
}
