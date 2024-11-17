<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_asset_status_line}}`.
 */
class m210617_150243_create_customer_asset_status_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_asset_status_line}}', [
            'id' => $this->primaryKey(),
            'asset_status_id' => $this->integer(),
            'checklist_id' => $this->integer(),
            'check_status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_asset_status_line}}');
    }
}
