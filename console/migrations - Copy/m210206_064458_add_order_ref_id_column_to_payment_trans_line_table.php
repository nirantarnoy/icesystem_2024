<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%payment_trans_line}}`.
 */
class m210206_064458_add_order_ref_id_column_to_payment_trans_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payment_trans_line}}', 'order_ref_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%payment_trans_line}}', 'order_ref_id');
    }
}
