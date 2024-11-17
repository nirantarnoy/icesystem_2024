<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer}}`.
 */
class m210122_163038_add_address_column_to_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer}}', 'address', $this->string());
        $this->addColumn('{{%customer}}', 'phone', $this->string());
        $this->addColumn('{{%customer}}', 'payment_method_id', $this->integer());
        $this->addColumn('{{%customer}}', 'payment_term_id', $this->integer());
        $this->addColumn('{{%customer}}', 'branch_no', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer}}', 'address');
        $this->dropColumn('{{%customer}}', 'phone');
        $this->dropColumn('{{%customer}}', 'payment_method_id');
        $this->dropColumn('{{%customer}}', 'payment_term_id');
        $this->dropColumn('{{%customer}}', 'branch_no');
    }
}
