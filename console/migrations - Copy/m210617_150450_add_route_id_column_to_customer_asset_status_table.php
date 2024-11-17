<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer_asset_status}}`.
 */
class m210617_150450_add_route_id_column_to_customer_asset_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer_asset_status}}', 'route_id', $this->integer());
        $this->addColumn('{{%customer_asset_status}}', 'company_id', $this->integer());
        $this->addColumn('{{%customer_asset_status}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer_asset_status}}', 'route_id');
        $this->dropColumn('{{%customer_asset_status}}', 'company_id');
        $this->dropColumn('{{%customer_asset_status}}', 'branch_id');
    }
}
