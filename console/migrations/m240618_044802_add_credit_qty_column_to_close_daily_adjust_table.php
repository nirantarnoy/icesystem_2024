<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%close_daily_adjust}}`.
 */
class m240618_044802_add_credit_qty_column_to_close_daily_adjust_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%close_daily_adjust}}', 'credit_qty', $this->float());
        $this->addColumn('{{%close_daily_adjust}}', 'issue_car_qty', $this->float());
        $this->addColumn('{{%close_daily_adjust}}', 'issue_transfer_qty', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%close_daily_adjust}}', 'credit_qty');
        $this->dropColumn('{{%close_daily_adjust}}', 'issue_car_qty');
        $this->dropColumn('{{%close_daily_adjust}}', 'issue_transfer_qty');
    }
}
