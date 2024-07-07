<?php

use yii\db\Migration;

/**
 * Class m220627_034658_add_logout_datetime_column_to_transaction_pos_sale_sum
 */
class m220627_034658_add_logout_datetime_column_to_transaction_pos_sale_sum extends Migration
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
        echo "m220627_034658_add_logout_datetime_column_to_transaction_pos_sale_sum cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220627_034658_add_logout_datetime_column_to_transaction_pos_sale_sum cannot be reverted.\n";

        return false;
    }
    */
}
