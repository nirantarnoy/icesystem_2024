<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%price_customer_type}}`.
 */
class m210509_021127_add_company_id_column_to_price_customer_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%price_customer_type}}', 'company_id', $this->integer());
        $this->addColumn('{{%price_customer_type}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%price_customer_type}}', 'company_id');
        $this->dropColumn('{{%price_customer_type}}', 'branch_id');
    }
}
