<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%asset_check_list}}`.
 */
class m210617_123857_add_company_column_to_asset_check_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%asset_check_list}}', 'company_id', $this->integer());
        $this->addColumn('{{%asset_check_list}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%asset_check_list}}', 'company_id');
        $this->dropColumn('{{%asset_check_list}}', 'branch_id');
    }
}
