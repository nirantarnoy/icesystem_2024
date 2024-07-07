<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer_asset_request}}`.
 */
class m221218_050315_add_location_column_to_customer_asset_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer_asset_request}}', 'location', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer_asset_request}}', 'location');
    }
}
