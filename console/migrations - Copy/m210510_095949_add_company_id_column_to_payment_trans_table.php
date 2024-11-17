<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%payment_trans}}`.
 */
class m210510_095949_add_company_id_column_to_payment_trans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payment_trans}}', 'company_id', $this->integer());
        $this->addColumn('{{%payment_trans}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%payment_trans}}', 'company_id');
        $this->dropColumn('{{%payment_trans}}', 'branch_id');
    }
}
