<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_asset_request}}`.
 */
class m221213_071828_create_customer_asset_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_asset_request}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(),
            'asset_id' => $this->integer(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'status' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_asset_request}}');
    }
}
