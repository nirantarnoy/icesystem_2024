<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer_asset_status}}`.
 */
class m220715_092551_add_latlong_column_to_customer_asset_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer_asset_status}}', 'latlong', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer_asset_status}}', 'latlong');
    }
}
