<?php

use yii\db\Migration;

/**
 * Class m211217_110950_change_type_to_stock_trans_table
 */
class m211217_110950_change_type_to_stock_trans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(){
        $this->alterColumn('stock_trans', 'qty', 'float');//timestamp new_data_type
    }

    public function down() {
        $this->alterColumn('stock_trans','qty', 'int' );//int is old_data_type
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211217_110950_change_type_to_stock_trans_table cannot be reverted.\n";

        return false;
    }
    */
}
