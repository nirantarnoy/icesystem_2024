<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%payment_term}}`.
 */
class m210405_093827_add_company_id_column_to_payment_term_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payment_term}}', 'company_id', $this->integer());
        $this->addColumn('{{%payment_term}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%payment_term}}', 'company_id');
        $this->dropColumn('{{%payment_term}}', 'branch_id');
    }
}
