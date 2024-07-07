<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%production_status}}`.
 */
class m220707_160906_add_company_id_column_to_production_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%production_status}}', 'company_id', $this->integer());
        $this->addColumn('{{%production_status}}', 'branch_id', $this->integer());
        $this->addColumn('{{%production_status}}', 'user_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%production_status}}', 'company_id');
        $this->dropColumn('{{%production_status}}', 'branch_id');
        $this->dropColumn('{{%production_status}}', 'user_id');
    }
}
