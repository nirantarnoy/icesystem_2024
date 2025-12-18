<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%delivery_not_full_pay}}`.
 */
class m251123_073250_add_payment_name_column_to_delivery_not_full_pay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%delivery_not_full_pay}}', 'payment_name', $this->string());
        $this->addColumn('{{%delivery_not_full_pay}}', 'payment_account', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%delivery_not_full_pay}}', 'payment_name');
        $this->dropColumn('{{%delivery_not_full_pay}}', 'payment_account');
    }
}
