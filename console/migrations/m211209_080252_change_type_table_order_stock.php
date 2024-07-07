<?php

use yii\db\Migration;

/**
 * Class m211209_080252_change_type_table_order_stock
 */
class m211209_080252_change_type_table_order_stock extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(){
        $this->alterColumn('order_stock', 'qty', 'float');//timestamp new_data_type
        $this->alterColumn('order_stock', 'avl_qty', 'float');//timestamp new_data_type
    }

    public function down() {
        $this->alterColumn('order_stock','qty', 'int' );//int is old_data_type
        $this->alterColumn('order_stock','avl_qty', 'int' );//int is old_data_type
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211209_080252_change_type_table_order_stock cannot be reverted.\n";

        return false;
    }
    */
}
