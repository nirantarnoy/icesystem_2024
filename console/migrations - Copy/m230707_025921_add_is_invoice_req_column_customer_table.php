<?php

use yii\db\Migration;

/**
 * Class m230707_025921_add_is_invoice_req_column_customer_table
 */
class m230707_025921_add_is_invoice_req_column_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230707_025921_add_is_invoice_req_column_customer_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230707_025921_add_is_invoice_req_column_customer_table cannot be reverted.\n";

        return false;
    }
    */
}
