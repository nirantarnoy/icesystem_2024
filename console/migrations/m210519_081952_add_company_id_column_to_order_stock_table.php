<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order_stock}}`.
 */
class m210519_081952_add_company_id_column_to_order_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order_stock}}', 'company_id', $this->integer());
        $this->addColumn('{{%order_stock}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order_stock}}', 'company_id');
        $this->dropColumn('{{%order_stock}}', 'branch_id');
    }
}
