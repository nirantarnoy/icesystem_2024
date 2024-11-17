<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_asset_status_photo}}`.
 */
class m220716_014142_create_customer_asset_status_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_asset_status_photo}}', [
            'id' => $this->primaryKey(),
            'customer_asset_id' => $this->integer(),
            'photo' => $this->string(),
            'company_id'=> $this->integer(),
            'branch_id'=> $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_asset_status_photo}}');
    }
}
