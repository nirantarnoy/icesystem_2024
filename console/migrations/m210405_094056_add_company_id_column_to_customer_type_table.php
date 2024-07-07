<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer_type}}`.
 */
class m210405_094056_add_company_id_column_to_customer_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer_type}}', 'company_id', $this->integer());
        $this->addColumn('{{%customer_type}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer_type}}', 'company_id');
        $this->dropColumn('{{%customer_type}}', 'branch_id');
    }
}
