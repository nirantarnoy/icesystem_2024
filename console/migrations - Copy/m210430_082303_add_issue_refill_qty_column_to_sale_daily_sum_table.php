<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sale_daily_sum}}`.
 */
class m210430_082303_add_issue_refill_qty_column_to_sale_daily_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_daily_sum}}', 'issue_refill_qty', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_daily_sum}}', 'issue_refill_qty');
    }
}
