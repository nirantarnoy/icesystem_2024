<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%payment_method}}`.
 */
class m210214_113817_add_pay_type_column_to_payment_method_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payment_method}}', 'pay_type', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%payment_method}}', 'pay_type');
    }
}
