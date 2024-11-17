<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%payment_receive_line}}`.
 */
class m210312_144450_add_payment_channel_id_column_to_payment_receive_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payment_receive_line}}', 'payment_channel_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%payment_receive_line}}', 'payment_channel_id');
    }
}
