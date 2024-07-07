<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%transaction_car_sale}}`.
 */
class m220611_153523_add_company_id_column_to_transaction_car_sale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transaction_car_sale}}', 'company_id', $this->integer());
        $this->addColumn('{{%transaction_car_sale}}', 'branch_id', $this->integer());
        $this->addColumn('{{%transaction_car_sale}}', 'created_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%transaction_car_sale}}', 'company_id');
        $this->dropColumn('{{%transaction_car_sale}}', 'branch_id');
        $this->dropColumn('{{%transaction_car_sale}}', 'created_at');
    }
}
