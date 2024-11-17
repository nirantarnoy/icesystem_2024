<?php

use yii\db\Migration;

/**
 * Class m210429_145223_add_total_refill_column_to_sale_daily_sum
 */
class m210429_145223_add_total_refill_column_to_sale_daily_sum extends Migration
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
        echo "m210429_145223_add_total_refill_column_to_sale_daily_sum cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210429_145223_add_total_refill_column_to_sale_daily_sum cannot be reverted.\n";

        return false;
    }
    */
}
