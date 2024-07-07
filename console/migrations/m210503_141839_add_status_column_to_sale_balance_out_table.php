<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sale_balance_out}}`.
 */
class m210503_141839_add_status_column_to_sale_balance_out_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_balance_out}}', 'status', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_balance_out}}', 'status');
    }
}
