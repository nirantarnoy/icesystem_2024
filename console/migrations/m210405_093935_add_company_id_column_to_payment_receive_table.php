<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%payment_receive}}`.
 */
class m210405_093935_add_company_id_column_to_payment_receive_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payment_receive}}', 'company_id', $this->integer());
        $this->addColumn('{{%payment_receive}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%payment_receive}}', 'company_id');
        $this->dropColumn('{{%payment_receive}}', 'branch_id');
    }
}
