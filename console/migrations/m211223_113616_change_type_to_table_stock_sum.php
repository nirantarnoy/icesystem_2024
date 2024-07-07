<?php

use yii\db\Migration;

/**
 * Class m211223_113616_change_type_to_table_stock_sum
 */
class m211223_113616_change_type_to_table_stock_sum extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(){
        $this->alterColumn('stock_sum', 'qty', 'float');//timestamp new_data_type
    }

    public function down() {
        $this->alterColumn('stock_sum','qty', 'int' );//int is old_data_type
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211223_113616_change_type_to_table_stock_sum cannot be reverted.\n";

        return false;
    }
    */
}
