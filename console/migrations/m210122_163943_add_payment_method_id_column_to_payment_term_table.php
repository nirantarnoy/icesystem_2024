<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%payment_term}}`.
 */
class m210122_163943_add_payment_method_id_column_to_payment_term_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payment_term}}', 'payment_method_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%payment_term}}', 'payment_method_id');
    }
}
