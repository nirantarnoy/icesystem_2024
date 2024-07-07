<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%production}}`.
 */
class m211030_020324_add_company_id_column_to_production_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%production}}', 'company_id', $this->integer());
        $this->addColumn('{{%production}}', 'branch_id', $this->integer());
        $this->addColumn('{{%production}}', 'delivery_route_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%production}}', 'company_id');
        $this->dropColumn('{{%production}}', 'branch_id');
        $this->dropColumn('{{%production}}', 'delivery_route_id');
    }
}
