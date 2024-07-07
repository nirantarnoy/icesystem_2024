<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%transaction_pos_sale_sum}}`.
 */
class m220624_091821_add_company_id_column_to_transaction_pos_sale_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transaction_pos_sale_sum}}', 'company_id', $this->integer());
        $this->addColumn('{{%transaction_pos_sale_sum}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%transaction_pos_sale_sum}}', 'company_id');
        $this->dropColumn('{{%transaction_pos_sale_sum}}', 'branch_id');
    }
}
