<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer_asset_status}}`.
 */
class m210617_150114_add_customer_id_column_to_customer_asset_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer_asset_status}}', 'customer_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer_asset_status}}', 'customer_id');
    }
}
