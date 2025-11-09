<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer}}`.
 */
class m241030_090440_add_cancel_use_date_column_to_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer}}', 'cancel_use_date', $this->datetime());
        $this->addColumn('{{%customer}}', 'cancel_use_reason', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer}}', 'cancel_use_date');
        $this->dropColumn('{{%customer}}', 'cancel_use_reason');
    }
}
