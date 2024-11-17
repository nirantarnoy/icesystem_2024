<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sale_daily_sum}}`.
 */
class m210925_102959_add_prod_repack_qty_column_to_sale_daily_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_daily_sum}}', 'prod_repack_qty', $this->float());
        $this->addColumn('{{%sale_daily_sum}}', 'scrap_qty', $this->float());
        $this->addColumn('{{%sale_daily_sum}}', 'company_id', $this->integer());
        $this->addColumn('{{%sale_daily_sum}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_daily_sum}}', 'prod_repack_qty');
        $this->dropColumn('{{%sale_daily_sum}}', 'scrap_qty');
        $this->dropColumn('{{%sale_daily_sum}}', 'company_id');
        $this->dropColumn('{{%sale_daily_sum}}', 'branch_id');
    }
}
