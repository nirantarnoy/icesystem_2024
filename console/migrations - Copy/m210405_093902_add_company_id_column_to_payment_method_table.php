<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%payment_method}}`.
 */
class m210405_093902_add_company_id_column_to_payment_method_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payment_method}}', 'company_id', $this->integer());
        $this->addColumn('{{%payment_method}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%payment_method}}', 'company_id');
        $this->dropColumn('{{%payment_method}}', 'branch_id');
    }
}
