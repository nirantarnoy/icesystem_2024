<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%orders}}`.
 */
class m210119_161725_add_payment_term_id_column_to_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%orders}}', 'payment_term_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%orders}}', 'payment_term_id');
    }
}
